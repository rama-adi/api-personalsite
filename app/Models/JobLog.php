<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class JobLog extends Model
{
    use HasFactory;

    protected $guarded = [];
    const CLEANUP_RATIO = 1000; // if > 1000 logs then clean

    public static function createLog(string $title, mixed $class): JobLog
    {
        return JobLog::create([
            'title' => $title,
            'status' => "WORKING",
            'job_class' => get_class($class)
        ]);
    }

    public function appendLog(string $text)
    {
        $this->update([
            'log' => $this->log . PHP_EOL . sprintf("[%s] : %s", now(), $text)
        ]);
    }

    public function markAsDone()
    {
        $this->update([
            'status' => "DONE",
            'finished_at' => now()
        ]);

        $this->cleanup();

        $this->appendLog("Job processing done");
    }

    public function cleanup()
    {
        $this->appendLog("Checking if cleanup is needed...");

        if ($this->count('id') > self::CLEANUP_RATIO) {
            JobLog::orderBy('created_at', 'asc')->take(1000)->delete();
            $this->appendLog("Cleanup done");
        }
    }
}
