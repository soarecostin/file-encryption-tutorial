<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MoveFileToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename . '.enc';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Upload file to S3
        $result = Storage::disk('s3')->putFileAs(
            '/',
            new File(storage_path('app/' . $this->filename)),
            $this->filename
        );

        // Forces collection of any existing garbage cycles
        // If we don't add this, in some cases the file remains locked
        gc_collect_cycles();

        if ($result == false) {
            throw new Exception("Couldn't upload file to S3");
        }

        // delete file from local filesystem
        if (!Storage::disk('local')->delete($this->filename)) {
            throw new Exception('File could not be deleted from the local filesystem ');
        }
    }
}
