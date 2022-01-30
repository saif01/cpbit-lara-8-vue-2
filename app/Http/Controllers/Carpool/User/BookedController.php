<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarppolCar;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Room\CommonFunctions;


class BookedController extends Controller
{
    use CommonFunctions;

    //data
    public function data(){

        $allData = CarpoolBooking::with('car', 'driver')
            ->where('user_id', Auth::user()->id)
            ->where('status', '=', '1')
            ->where('end', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->get();
       
       // dd($allData);

        return response()->json($allData, 200);
    }


    //canceled
    public function canceled(){

        $allData = CarpoolBooking::with('car', 'driver')
            ->where( 'user_id', Auth::user()->id )
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->take(30)
            ->get();

       // dd($allData);

        return response()->json($allData, 200);
    }

   
    // byroom booked data
    public function byroom(Request $request){

       
        // Request Arry convert in object
        $reqObjData = (object) $request->item;
        
        //dd($reqObjData , $request->all());

        $id = $reqObjData->id;
        $room_id = $reqObjData->room_id;

        $start = $reqObjData->start; 
        $end   = $reqObjData->end; 

        // $currentDateTime = Carbon::now();
        // $newDateTime = Carbon::now()->addDays(-5);
        $back15Start = Carbon::create($start)->addDays(-15)->toDateTimeString();
        $next15End = Carbon::create($end)->addDays(15)->toDateTimeString();

        
        $bookingData = CarpoolBooking::where('id', '!=', $id)
            ->where('car_id', '=', $car_id)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$back15Start' AND '$next15End' OR `end` BETWEEN '$back15Start' AND '$next15End' OR '$back15Start' BETWEEN `start` AND `end` OR '$next15End' BETWEEN `start` AND `end` )")
            ->orderBy('start')
            ->get();

        //dd($back15Start, $next15End, $bookingData);

        return response()->json($bookingData);

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

        $id               = $request->id;
        $car_id          = $request->car_id;
        $car_name        = $request->car_name;
        $purpose          = $request->purpose;
        $start            = $request->start;
        $end              = $request->end;
        $duration         = $this->DayOrHoure($start, $end);

        // Checking Booked 
        $booked =    $this->CheckModifyBookingHaveOrNot($id, $car_id, $start, $end);

        if($booked){
            return response()->json([
                'status'=>'error',
                'msg'=>'Room Was <b>Booked</b> At This Time !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

        $data       = CarpoolBooking::find($id);

        $data->car_id       = $car_id;
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
        $message = "Modify Status,%0A Modify By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $room_name,%0A Start: $startLine,%0A End: $endLine,%0A Duration : $duration. ";
        //Send Line Message
        $this->lineMsg($message);
        // Save In DB
        $success             = $data->save();

        if($success){
            return response()->json([
                'status'=>'success',
                'msg'=>'Modified Successfully &#128513;', 
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


    // Change Booking Status
    public function status($id){
        // dd($id);

        $data = CarpoolBooking::find($id);

        if($data->status == 1){
            $data->status = null;
        }else{
            $data->status = 1;
        }

       $data->save();

        return response()->json('success', 200);
    }

}
