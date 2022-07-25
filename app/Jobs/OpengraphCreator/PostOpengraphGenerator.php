<?php

namespace App\Jobs\OpengraphCreator;

use App\Models\Post;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $postId)
    {
        $this->post = Post::find($postId);
    }

    private function storeImage(string $base64Image): string
    {

        $storage = Storage::disk(config('filesystems.default'));

        $filename = sprintf("%s/%s-%s.jpg", $this->location, $this->post->id, md5(now()->unix()));


        $storage->put($filename, base64_decode($base64Image), [
            'ContentType' => 'image/jpeg'
        ]);

        if ($this->post->og_image !== null && $this->post->og_image !== $this->defaultFailedFile) {
            $storage->delete($this->post->og_image);
        }


        return $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {

        try {
            $image = Browsershot::url(route('og-image.post', ['post' => $this->post]))
                ->waitUntilNetworkIdle()
                ->showBackground()
                ->windowSize(1200, 630)
                ->setScreenshotType('jpeg', 100)
                ->base64Screenshot();


            $this->post->update([
                'og_image' => $this->storeImage($image)
            ]);


        } catch (Exception) {
            $this->post->update([
                'og_image' => $this->defaultFailedFile
            ]);
        }

    }
}
