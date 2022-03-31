<?php

namespace App\Console\Commands\PBI;

use Illuminate\Console\Command;

use App\Http\Controllers\PBI\Admin\API\ScheduleController;

class BI_EXPENSE_Daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BI_EXPENSE_Daily';

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
        $Obj->action('PbiExpense', 60);
        return Command::SUCCESS;
    }
}