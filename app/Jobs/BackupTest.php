<?php

namespace App\Jobs;

use App\Models\Hadith;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BackupTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public function __construct(
        protected string $filename

    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $hadiths = Hadith::all();
        $jsonData = json_encode($hadiths, JSON_PRETTY_PRINT);


        // Save JSON data to a file
        file_put_contents(storage_path('app/' . $this->filename), $jsonData);

    }
}
