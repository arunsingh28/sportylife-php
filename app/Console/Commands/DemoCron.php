<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\sendFrcDetail;
use Mail;
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

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
         \Log::info("Cron is working fine!");
        //  \Mail::raw('Your Verification code is: ' , function ($message) {
        //         $message->to("realhimanshubansal@gmail.com")
        //         ->subject("OTP");
        //     });
         $this->info('Demo:Cron Cummand Run successfully!');
        // return Command::SUCCESS;
    }
}
