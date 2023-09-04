<?php

namespace App\Console\Commands;

use App\Mail\DailyReportEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-report-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Mail::send(new DailyReportEmail());
        $this->info('Daily report email sent successfully!');
    }
}
