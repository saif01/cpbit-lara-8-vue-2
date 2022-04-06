<?php

namespace App\Console\Commands\Network;

use Illuminate\Console\Command;

use App\Http\Controllers\Network\Admin\Mainip\ScheduleController;

class MainIpPing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MainIpPing';

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
       

        $Obj = new ScheduleController();

        $Obj->MainIpPingBySchedule();

        \Log::info("Cron Main IP Ping");
        return Command::SUCCESS;
    }
}
