<?php

namespace App\Http\Controllers\Room\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room\RoomBooking;
use App\Models\Room\Room;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Room\CommonFunctions;

class BookingController extends Controller
{
    use CommonFunctions;

    //data
    public function data(){
        $allData = RoomBooking::where('status', '1')
        ->with('room', 'bookby')
        ->get();

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

       

    
        $room_id          = $request->room_id;
        $room_name        = $request->room_name;
        $purpose          = $request->purpose;
        $start            = $request->start;
        $end              = $request->end;
        $duration         = $this->DayOrHoure($start, $end);

        // Checking Booked 
        $booked =    $this->CheckBookingHaveOrNot($room_id, $start, $end);

        if($booked){
            return response()->json([
                'status'=>'error',
                'msg'=>'Room Was <b>Booked</b> At This Time !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

        $data = new RoomBooking();

        $data->room_id       = $room_id;
        $data->user_id       = Auth::user()->id;
        $data->start         = $start;
        $data->end           = $end;
        $data->duration      = $duration;
        $data->purpose       = $purpose;
        $data->status        = 1;

        //For Line Msg Sending Variable
        $userName           = Auth::user()->name;
        $department         = Auth::user()->department;
        $startLine          = date("j-M-Y, g:i A", strtotime($start));
        $endLine            = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine        = str_replace('&', 'and', $purpose);
        //Send Line Message
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $room_name,%0A Start: $startLine,%0A End: $endLine,%0A Duration : $duration. ";
        //Send Line Message
        $this->lineMsg($message);
        // Save In DB
        $success             = $data->save();

        if($success){
            return response()->json([
                'status'=>'success',
                'msg'=>'Booked Successfully &#128513;', 
                'icon'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>'success',
                'msg' => 'Data not save in DB !!',
                'icon'=>'error'
            ]);
        }

    }




    




}
