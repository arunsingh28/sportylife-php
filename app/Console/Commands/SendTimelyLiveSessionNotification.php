<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ApiHelper;


class SendTimelyLiveSessionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendTimelyLiveSessionNotification:cron';

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
        // $sendTimelyLiveSessionNotification = ApiHelper::sendTimelyLiveSessionNotification();
        //  \Log::info($sendTimelyLiveSessionNotification);

        return Command::SUCCESS;
    }
}
