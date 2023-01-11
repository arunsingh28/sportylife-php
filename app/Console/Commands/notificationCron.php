<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ApiHelper;
class notificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendnotification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         $sendemail = ApiHelper::sendLiveSessionNotification();
        //  $sendTimelyLiveSessionNotificationForAdult = ApiHelper::sendTimelyLiveSessionNotificationForAdult();
        // \Log::info("sendnotification:cron");
    }
}
