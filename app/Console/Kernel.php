<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('command:TodayBookedCar')
            ->dailyAt('08:00');
            //->everyTenMinutes();
            //->everyFiveMinutes();
            //->everyMinute();

        $schedule->command('command:TodayBookedRoom')
            ->dailyAt('08:01');
            //->everyTenMinutes();
            //->everyFiveMinutes();
            //->everyMinute();

       
        $schedule->command('command:MainIpPing')
            ->everyTenMinutes();
            //->everyFiveMinutes();
            //->everyMinute();
    
                    


                    
        // BI_EXPENSE
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_EXPENSE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_EXPENSE schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_EXPENSE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_EXPENSE_Daily schedule Error"); });



        //***************************************************//
        //***************************************************//
        //********************Start Farm *********************//
        //***************************************************//
        //***************************************************//

        // BI_FARM_AQUA_PURCHASE
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_FARM_AQUA_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FARM_AQUA_PURCHASE schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FARM_AQUA_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FARM_AQUA_PURCHASE_Daily schedule Error"); });

        
        // '9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'
        // BI_FARM_AQUA_SALES
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_FARM_AQUA_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FARM_AQUA_SALES schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FARM_AQUA_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FARM_AQUA_SALES_Daily schedule Error"); });


        // BI_FARM_POULTRY_PURCHASE
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_FARM_POULTRY_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FARM_POULTRY_PURCHASE schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FARM_POULTRY_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FARM_POULTRY_PURCHASE_Daily schedule Error"); });


        // '03:30', '08:30', '09:30', '10:30', '11:30', '14:30', '15:30', '16:30'
        // BI_FARM_POULTRY_SALES
        foreach (['03:30', '08:30', '09:30', '10:30', '11:30', '14:30', '15:30', '16:30'] as $time) {
            $schedule->command('command:BI_FARM_POULTRY_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FARM_POULTRY_SALES schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FARM_POULTRY_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FARM_POULTRY_SALES_Daily schedule Error"); });


        //***************************************************//
        //***************************************************//
        //********************End Farm *********************//
        //***************************************************//
        //***************************************************//





        //***************************************************//
        //***************************************************//
        //********************Start Feed *********************//
        //***************************************************//
        //***************************************************//

        // '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'
        // BI_FEED_PRODUCTION
        foreach (['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'] as $time) {
            $schedule->command('command:BI_FEED_PRODUCTION')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FEED_PRODUCTION schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FEED_PRODUCTION_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FEED_PRODUCTION_Daily schedule Error"); });
     

        // BI_FEED_PURCHASE
        foreach (['9:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time) {
            $schedule->command('command:BI_FEED_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FEED_PURCHASE schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FEED_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FEED_PURCHASE_Daily schedule Error"); });


        // BI_FEED_SALES
        foreach (['9:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time) {
            $schedule->command('command:BI_FEED_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FEED_SALES schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FEED_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FEED_SALES_Daily schedule Error"); });

        //***************************************************//
        //***************************************************//
        //********************End Feed *********************//
        //***************************************************//
        //***************************************************//






        //***************************************************//
        //***************************************************//
        //********************Start Food *********************//
        //***************************************************//
        //***************************************************//

        // '9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'
        // BI_FOOD_FURTHER_SALES
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_FOOD_FURTHER_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FOOD_FURTHER_SALES schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FOOD_FURTHER_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FOOD_FURTHER_SALES_Daily schedule Error"); });



        // '00:30', '05:30', '09:30', '13:30', '15:30', '17:30', '19:30', '21:30'
        // BI_FOOD_SLAUGHTER_SALES
        foreach (['00:30', '05:30', '09:30', '13:30', '15:30', '17:30', '19:30', '21:30'] as $time) {
            $schedule->command('command:BI_FOOD_SLAUGHTER_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FOOD_SLAUGHTER_SALES schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FOOD_SLAUGHTER_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FOOD_SLAUGHTER_SALES_Daily schedule Error"); });


        //***************************************************//
        //***************************************************//
        //********************End Food *********************//
        //***************************************************//
        //***************************************************//






        



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
