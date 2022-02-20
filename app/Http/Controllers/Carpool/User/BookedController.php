<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolDestination;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Carpool\CommonFunctions;


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

        return response()->json($allData, 200);
    }


    // destinations
    public function destinations(){
        $allData = CarpoolDestination::orderBy('name')->get();
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

        return response()->json($allData, 200);
    }

   
    // bycar booked data
    public function bycar(Request $request){

       
        // Request Arry convert in object
        $reqObjData = (object) $request->item;
        

        $id = $reqObjData->id;
        $car_id = $reqObjData->car_id;

        $start = $reqObjData->start; 
        $end   = $reqObjData->end; 

        $back15Start = Carbon::create($start)->addDays(-15)->toDateTimeString();
        $next15End = Carbon::create($end)->addDays(15)->toDateTimeString();

        
        $bookingData = CarpoolBooking::where('id', '!=', $id) 
            ->where('car_id', '=', $car_id)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$back15Start' AND '$next15End' OR `end` BETWEEN '$back15Start' AND '$next15End' OR '$back15Start' BETWEEN `start` AND `end` OR '$next15End' BETWEEN `start` AND `end` )")
            ->orderBy('start')
            ->get();


        return response()->json($bookingData);

    }

    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'destination'    =>  'required',
            'start'          =>  'required',
            'end'            =>  'required',
            'purpose'        =>  'required|max:500',
        ]);

        $id               = $request->id;
        $car_id           = $request->car_id;
        $car_name         = $request->car_name;
        $purpose          = $request->purpose;
        $destination      = $request->destination;
        $start            = $request->start;
        $end              = $request->end;

        // Checking Booked 
        $booked =    $this->CheckModifyBookingHaveOrNot($id, $car_id, $start, $end);
        $leave  =    $this->CheckDriverLeaveOrNot($car_id, $start, $end);

        // Booked
        if($booked){
            return response()->json([
                'status'=>'error',
                'msg'=>'Room Was <b>Booked</b> At This Time !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

        // Leave
        if($leave){

            if($leave->type == 'lev'){
                return response()->json([
                    'status'=>'error',
                    'msg'=>'Driver in <b>Leave</b> At This Time !! &#128530;', 
                    'icon'=>'warning'
                ]);
            }

            if($leave->type == 'mant'){
                return response()->json([
                    'status'=>'error',
                    'msg'=>'Car in <b>Maintenance</b> At This Time !! &#128530;', 
                    'icon'=>'warning'
                ]);
            }

            if($leave->type == 'req'){
                return response()->json([
                    'status'=>'error',
                    'msg'=>'Car in <b>Police Requisition </b> At This Time !! &#128530;', 
                    'icon'=>'warning'
                ]);
            }
        }

        $data       = CarpoolBooking::find($id);
        $data->car_id        = $car_id;
        $data->user_id       = Auth::user()->id;
        $data->start         = $start;
        $data->end           = $end;
        $data->purpose       = $purpose;
        $data->destination   = $destination;
        $data->status        = 1;
        // Save In DB
        $success             = $data->save();


        // car and driver data
        $carDriData     = CarpoolCar::with('driver')->where('id', $car_id)->first();
        $carNumber      = $carDriData->number;
        $driverName     = $carDriData->driver->name;
        $driverContact  = $carDriData->driver->contact;
       
        //For Line Msg Sending Variable
        $userName           = Auth::user()->name;
        $department         = Auth::user()->department;
        $startLine          = date("j-M-Y, g:i A", strtotime($start));
        $endLine            = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine        = str_replace('&', 'and', $purpose);
        $destinationLine    = str_replace('&', 'and', $destination);

        //Send Line Message
        $message = "Modify Status,%0A Modify By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($driverContact),%0A Car: $carNumber,%0A Start: $startLine,%0A End: $endLine.";

        //Send Line Message
        $this->lineMsg($message);
        

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
