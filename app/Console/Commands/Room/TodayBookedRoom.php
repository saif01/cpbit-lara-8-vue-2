<?php

namespace App\Console\Commands\Room;

use Illuminate\Console\Command;

use App\Http\Controllers\Room\CommonFunctions;

class TodayBookedRoom extends Command
{
    use CommonFunctions;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TodayBookedRoom';

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
        \Log::info("Cron Daily Room Booked Line Msg Done");
        return Command::SUCCESS;
    }
}
