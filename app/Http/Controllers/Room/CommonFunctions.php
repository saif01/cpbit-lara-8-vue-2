<?php

namespace App\Http\Controllers\Room;

use App\Models\Room\RoomBooking;
use App\Models\Room\Room;
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


    //Check Meeting Room Booking Have or Not
    public function CheckBookingHaveOrNot($room_id, $start, $end){

        $bookingData = RoomBooking::where('room_id', '=', $room_id)
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


    //Check Meeting Room Booking Have or Not Except ID
    public function CheckModifyBookingHaveOrNot($id, $room_id, $start, $end){

        // $bookingData = DB::table('room_bookings')
        //     ->where('id', '!=', $id)
        //     ->where('room_id', '=', $room_id)
        //     ->where('status', '=', '1')
        //     ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
        //     ->count();

        $bookingData = RoomBooking::where('id', '!=', $id)
            ->where('room_id', '=', $room_id)
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


    //Today Booked Message Send
    public function DailyBookedLineMsg(){

        // // $today = '2020-11-18';
        //  $today = Carbon::today();

        //  $allData = DB::table('room_bookings')
        //          ->whereDate('room_bookings.start', '=', $today)
        //          ->where('room_bookings.status', '=', '1')
        //          ->join('users', 'users.id', 'room_bookings.user_id')
        //          ->join('rooms', 'rooms.id', 'room_bookings.room_id')
        //          ->select('room_bookings.start', 'room_bookings.end', 'room_bookings.purpose', 'room_bookings.hours', 'users.name','users.office', 'rooms.name as roomName')
        //          ->get();

        $allData = RoomBooking::with('bookby', 'room')
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
             $department     = str_replace('&', 'and', $data->bookby->department);
             $purposeLine   = str_replace('&', 'and', $data->purpose);
             $roomName      = $data->room->name;
             $duration      = $data->duration;


             //*************For Sending Line Group Message*******************//
             $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Start: $startLine,%0A End: $endLine,%0A Duration : $duration. ";


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

          //Room Booking Group
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
