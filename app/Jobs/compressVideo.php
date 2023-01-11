<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFmpeg;

use FFmpeg\Coordinate\Dimension;

use FFmpeg\Format\Video\X264;

class compressVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $new = 'compressed' . $this->file;
        FFMpeg::fromDisk('videos')
            ->open($this->file)
            ->export()
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->resize(1280, 720)
            ->save($new);
        if (file_exists("public/uploads/videos/" . $this->file)) {
            unlink("public/uploads/videos/" . $this->file);
        }
    }
}
