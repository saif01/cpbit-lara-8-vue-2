<?php

namespace App\Http\Controllers\Network\Admin\Mainip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Network\Admin\CommonFunctions;
use App\Models\Network\NetworkMainip;
use App\Models\Network\NetworkMainipPing;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    use CommonFunctions;

    //All Main IP Ping Check
    public function MainIpPingBySchedule()
    {
        //$nowTimeOnly = "20:30:00";
        $nowTimeOnly = date("H:i:s");

        $allActiveIp= NetworkMainIp::where('status', '=', '1')
        ->whereRaw("'$nowTimeOnly' BETWEEN start AND end")
        ->get();

        foreach ($allActiveIp as $ipData) {

            //IP Address
            $ip = $ipData->ip;
            $name = $ipData->name;
            //Define Ping Number At A Time
            $pingNumber = 2;

            $ArrData= $this->pingIp($ip, $pingNumber);


            if($pingNumber == 1 && isset( $ArrData[7] ) ){
                $latencyStr = $ArrData[7];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
                }
                elseif($pingNumber == 2 && isset( $ArrData[8] ) ){
                $latencyStr = $ArrData[8];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
                }
                elseif($pingNumber == 3 && isset( $ArrData[9] ) ){
                $latencyStr = $ArrData[9];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
                }
                elseif($pingNumber == 4 && isset( $ArrData[10] ) ){
                $latencyStr = $ArrData[10];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
                }
                else
                {
                    //For Offline IP
                    $latency = 0;
                    $status= "Offline";

                    // Offline Value Insert
                    $insert = new NetworkMainIpPing();

                    $insert->ip = $ip;
                    $insert->name = $name;
                    $insert->latency = $latency;
                    $insert->status = $status;
                    $success = $insert->save();

                    $nowTime = Carbon::now()->format('Y-m-d h:i:s A');
                    $message = "Offline Status: %0A Date: $nowTime, %0A IP: $ip,%0A Location: $name";
                    $this->lineMsg($message);

                }



            }
            //End Foreach

        // \Log::info("Cron is working for Main IP Ping");

    }


}
