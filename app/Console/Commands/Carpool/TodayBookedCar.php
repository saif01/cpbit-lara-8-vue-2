<?php

namespace App\Console\Commands\Carpool;

use Illuminate\Console\Command;

use App\Http\Controllers\Carpool\CommonFunctions;

class TodayBookedCar extends Command
{
    use CommonFunctions;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TodayBookedCar';

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
        $this->DailyBookedLineMsg();
        \Log::info("Cron Daily Booked Line Msg Done");
        return Command::SUCCESS;
    }
}
