<?php

namespace App\Http\Controllers\Network\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Network\NetworkMainIpPing;
use Carbon\Carbon;


trait CommonFunctions {

    
    // ping ip
    public function pingIp($ip, $pingNumber) {

        exec ("ping -n $pingNumber $ip", $ping_output, $value);
        //dd ($ping_output);
        return $ping_output;

    }

    // //Send Ping Request
    // public function pingIp($ip, $pingNumber) {
    //     exec ("ping -n $pingNumber $ip", $ping_output, $value);
    //     return $ping_output;
    // }


    //Single main IP Ping
    public function SinglePing($ip){
        
        $pingNumber = 2;

        $ArrData = $this->pingIp($ip, $pingNumber);



        if($pingNumber == 2 && isset( $ArrData[8] ) ){
            $latencyStr = $ArrData[8];
            $latency= explode("=", $latencyStr );

            $latency = ceil($latency[3]) ;
            $status= "Online";

            return "Online";

        }else{

            $latency = 0;
            $status= "Offline";

            return "Offline";

        }


    }



    //All Main Ip Ping By Browser
    public function AllPing($allActiveIp)
    {

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
                $data = new NetworkMainIpPing();

                $data->ip       = $ip;
                $data->name     = $name;
                $data->latency  = $latency;
                $data->status   = $status;
                $success        = $data->save();

                $nowTime = Carbon::now()->format('Y-m-d h:i:s A');
                $message = "Offline Status: %0A Date: $nowTime, %0A IP: $ip,%0A Location: $name";
                $this->lineMsg($message);

            }

        }
        //End Foreach
        return true;

    }



    //Line Message send
    public function lineMsg($message)
    {
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST
        curl_setopt($chOne, CURLOPT_POST, 1);
        // Message
        curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
        //��ҵ�ͧ�������ػ ������ 2 parameter imageThumbnail ���imageFullsize
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
        // follow redirects
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);

        // //Test Group
        // $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_test_key'),);  // ��ѧ����� Bearer ��� line authen code �

        //Network Monitor Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_network_key'),);  // ��ѧ����� Bearer ��� line authen code �

        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //RETURN
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);

            //************Status Print *************//

            //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            //echo "SMS send Successfully";
        }
        //Close connect
        curl_close($chOne);
    }

}


