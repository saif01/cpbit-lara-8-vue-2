<?php

namespace App\Console\Commands\CMS;

use Illuminate\Console\Command;

use App\Http\Controllers\CMS\Email\Hardware\EmailSend;

class HardwareMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:HardwareMail';

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
        EmailSend::SendBySchedule();
        return Command::SUCCESS;
    }
}
