<?php

namespace App\Jobs\OpengraphCreator;

use App\Models\JobLog;
use App\Models\Post;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class PostOpengraphGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private string $defaultFailedFile = "opengraph-images/posts/default.jpg";
    private string $location = "opengraph-images/posts";
    private Post $post;
    private JobLog $jobLog;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->post = Post::find($postId);
        $this->jobLog = JobLog::createLog($this->alreadyHasOpengraphImage()
            ? "Updating opengraph image for post ID #{$this->post->id}"
            : "Creating opengraph image for post ID #{$this->post->id}",
            $this
        );

    }

    private function storeImage(string $base64Image): string
    {

        $storage = Storage::disk(config('filesystems.default'));
        $filename = sprintf("%s/%s-%s.jpg", $this->location, $this->post->id, md5(now()->unix()));

        $storage->put($filename, base64_decode($base64Image), [
            'ContentType' => 'image/jpeg'
        ]);

        if ($this->alreadyHasOpengraphImage()) {
            $storage->delete($this->post->og_image);
        }

        return $filename;
    }

    private function alreadyHasOpengraphImage(): bool
    {
        return $this->post->og_image !== null && $this->post->og_image !== $this->defaultFailedFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {

            $this->jobLog->appendLog("Screenshotting with puppeteer...");

            $image = Browsershot::url(route('og-image.post', ['post' => $this->post]))
                ->waitUntilNetworkIdle()
                ->showBackground()
                ->windowSize(1200, 630)
                ->setScreenshotType('jpeg', 100)
                ->base64Screenshot();

            $this->jobLog->appendLog("Storing image...");


            $this->post->update([
                'og_image' => $this->storeImage($image)
            ]);

            $this->jobLog->appendLog("Image stored!");


        } catch (Exception $e) {
            $this->jobLog->appendLog("Failed to store image, using default image");
            $this->jobLog->appendLog("Error message: {$e->getMessage()}");
            $this->post->update([
                'og_image' => $this->defaultFailedFile
            ]);
        }

        $this->jobLog->markAsDone();
    }
}
