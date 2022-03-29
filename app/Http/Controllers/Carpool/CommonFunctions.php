<?php

namespace App\Http\Controllers\Carpool;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolLeaves;
use App\Models\Carpool\Carpool;
use App\Models\Carpool\CarpoolCar;
use Auth;
use Carbon\Carbon;

trait CommonFunctions {


    //Day or Hours
    public function DayOrHoure($startTime, $endTime)
    {
        $ts1 = strtotime($startTime);
        $ts2 = strtotime($endTime);
        $seconds = abs($ts1 - $ts2); # difference will always be positive
        $days = round($seconds / (60 * 60 * 24));
        if ($days >= 1) {
        return $days . " Days";
        } else {
        return round($seconds / (60 * 60), 2) . " Hours";
        }
    }

    //Check Meeting Car Booking Have or Not
    public function CheckDriverLeaveOrNot($car_id, $start, $end){

        $leaveData = CarpoolLeaves::select('type')
            ->where('car_id', '=', $car_id)
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->first();
            
        if($leaveData){
            return $leaveData;
        }else{
            return false;
        }

    }


    //Check Car Booking Have or Not
    public function CheckBookingHaveOrNot($car_id, $start, $end){

        $bookingData = CarpoolBooking::where('car_id', '=', $car_id)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        //return $bookingData;
        if($bookingData > 0){
            return true;
        }else{
            return false;
        }

    }


    //Check Car Booking Have or Not Except ID
    public function CheckModifyBookingHaveOrNot($id, $car_id, $start, $end){

        $bookingData = CarpoolBooking::where('id', '!=', $id)
            ->where('car_id', '=', $car_id)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();

        //return $bookingData;
        if($bookingData > 0){
            return true;
        }else{
            return false;
        }

    }


    //Check Car Use Deadline
    public function CheckCarUseDeadline($carId, $end_date){

        $data = CarpoolCar::where('id', $carId)
            ->where('last_use', '!=', '' )
            ->where('last_use', '<', $end_date)
            ->select('last_use')
            ->first();

            //dd($data);

            if( $data ){
                return true;
            }else{
                return false;
            }

    }

    // Check Not Commented
    public function CheckNotCommentedCount(){
        $data = CarpoolBooking::where('user_id', Auth::user()->id )
        ->where('status', '1')
        ->whereNull('comit_st')
        ->where('end', '<=', Carbon::now())
        ->count();

        return $data;
    }


    //Today Booked Message Send
    public function DailyBookedLineMsg(){

        $allData = CarpoolBooking::with('bookby', 'car', 'driver')
                 ->whereDate('start', Carbon::today())
                 ->where('status', 1)
                 ->get();
        // dd($allData);

        $count = 1;

        foreach( $allData as $data ){


            $today         = date("j-M-Y", strtotime( Carbon::today() ) );

            $startLine     = date("j-M-Y, g:i A", strtotime($data->start));
            $endLine       = date("j-M-Y, g:i A", strtotime($data->end));

            //  $startTime = date("g:i A", strtotime($data->start));
            //  $endTime = date("g:i A", strtotime($data->end));

            $userName      = $data->bookby->name;
            $department    = str_replace('&', 'and', $data->bookby->department);
            $purposeLine   = str_replace('&', 'and', $data->purpose);
            $destinationLine    = str_replace('&', 'and', $data->destination);

            if($data->car){
                $carName      = $data->car->name;
                $number       = $data->car->number;
            }else{
                $carName      = '';
                $number       = '';
            }

            if($data->driver){
                $driverName    = $data->driver->name;
                $contact       = $data->driver->contact;
            }else{
                $driverName    = '';
                $contact       = '';
            }
           
            

            //*************For Sending Line Group Message*******************//
            $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";

            // $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Car: $carName,%0A Start: $startLine,%0A End: $endLine,%0A Duration : $duration. ";


            //Send Line Message
            $this->lineMsg($message);

            $count++;

        }





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

        //Car Booking Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_room_key'),);  // ��ѧ����� Bearer ��� line authen code � env('APP_DEBUG')
        
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
