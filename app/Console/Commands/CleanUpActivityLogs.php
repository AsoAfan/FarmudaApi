<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

class CleanUpActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activityLogs:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup older than 40 days activities';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Activity::where('created_at', '>', now()->subDays(40))->get()->each(function ($activity){
            // TODO(: Backup database and delete all logs
        });
    }
}
