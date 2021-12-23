<?php

namespace App\Http\Controllers\Room\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room\RoomBooking;
use App\Models\Room\Room;

class BookingController extends Controller
{
    //data
    public function data(){
        $allData = RoomBooking::get()->toArray();

       // dd($allData);

        return response()->json($allData, 200);
    }

    // room
    public function room(Request $request){

        //dd( $request->selectData['start_date'], $request->all());

        // $start ="2021-12-23 10:00:00";
        // $end = "2021-12-23 23:00:00";

        $start = $request->selectData['start_date'] ." ". $request->selectData['start_time'];
        $end = $request->selectData['end_date'] ." ". $request->selectData['end_time'];

        // $bookingData = DB::table('room_bookings')
        // ->where('room_id', '=', $room_id)
        // ->where('status', '=', '1')
        // ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
        // ->count();


        $bookingData = RoomBooking::with('room')->with('bookby')
            ->where('status', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->orderBy('room_id')
            ->get();


        // Booked Room ID 
        if($bookingData){
            $booked_room_id = [];
            foreach($bookingData as $item){
                // Push All Room ID
                array_push($booked_room_id, $item->room_id); 
            }
        }

        //dd($start, $end);
        $roomData = Room::where('status', 1)
            ->whereNotIn('id', $booked_room_id)
            ->get();
      

        //dd( $booked_room_id, $bookingData, $roomData);

        return response()->json(['rooms'=> $roomData, 'bookings'=> $bookingData]);


    }


    // store
    public function store(Request $request){

        //dd($request->all());

        //Validate
        $this->validate($request,[
            'start'          =>  'required',
            'end'            =>  'required',
            'purpose'        =>  'required|max:500',
        ]);

        $data = new RoomBooking();

    
       $room_id          = $request->room_id;
       $room_name        = $request->room_name;
       $purpose          = $request->purpose;

       // start date and time
       $start_date          = $request->start;
       $start_time          = $request->startTime;
       $start_date_time     = $start_date." ".$start_time; //concat date with time
       $int_start_date_time = strtotime($start_date_time);  //convert integer for checking

       // end date start
       $end_date            = $request->end;
       $end_time            = $request->endTime;
       $end_date_time       = $end_date." ".$end_time;  //concat date with time
       $int_end_date_time   = strtotime($end_date_time);   //convert integer for checking


        //    $seconds    = abs($int_end_date_time - $int_start_date_time); //# difference will always be positive
        //    $hours      = round( ($seconds / (60 * 60)), 2);
       $hours      = $this->DayOrHoure($int_end_date_time, $int_start_date_time);


       $data->hours         = $hours;
       $data->purpose       = $purpose;
       $data->room_id       = $room_id;
       $data->user_id       = Auth::user()->id;
       $data->start         = $start_date_time;
       $data->end           = $end_date_time;




        $data->status     = 1;
        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Booked Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }




    //Day or Hours
    public function DayOrHoure($int_end_date_time, $int_start_date_time)
    {
        // $ts1 = strtotime($startTime);
        // $ts2 = strtotime($endTime);
        $seconds = abs($int_end_date_time - $int_start_date_time); # difference will always be positive
        $days = round($seconds / (60 * 60 * 24));
        if ($days >= 1) {
        return $days . " Days";
        } else {
        return round($seconds / (60 * 60), 2) . " Hours";
        }
    }





    //Check Meeting Room Booking Have or Not
    public function CheckBookingHaveOrNot($room_id, $start, $end){

        $bookingData = DB::table('room_bookings')
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

    //Check Meeting Room Booking Have or Not Except ID
    public function CheckModifyBookingHaveOrNot($id, $room_id, $start, $end){

        $bookingData = DB::table('room_bookings')
            ->where('id', '!=', $id)
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
     function DailyBookedLineMsg(){

        // // $today = '2020-11-18';
        //  $today = Carbon::today();

        //  $allData = DB::table('room_bookings')
        //          ->whereDate('room_bookings.start', '=', $today)
        //          ->where('room_bookings.status', '=', '1')
        //          ->join('users', 'users.id', 'room_bookings.user_id')
        //          ->join('rooms', 'rooms.id', 'room_bookings.room_id')
        //          ->select('room_bookings.start', 'room_bookings.end', 'room_bookings.purpose', 'room_bookings.hours', 'users.name','users.office', 'rooms.name as roomName')
        //          ->get();

        $allData = RoomBooking::with('user', 'room')
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

             $userName      = $data->user->name;
             $office        = str_replace('&', 'and', $data->user->office);
             $purposeLine   = str_replace('&', 'and', $data->purpose);
             $roomName      = $data->room->name;
             $hours         = $data->hours;


             //*************For Sending Line Group Message*******************//
             $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A office: $office,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Start: $startLine,%0A End: $endLine,%0A Booking : $hours. ";


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
          $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_room_key'),);  // ��ѧ����� Bearer ��� line authen code �

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
