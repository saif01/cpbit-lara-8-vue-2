<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolLeaves;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Carpool\CommonFunctions;

class BookingController extends Controller
{
    use CommonFunctions;

    //data
    public function data(){

        $allData = CarpoolBooking::where('status', '1')
        ->with('car', 'bookby')
        ->orderBy('id', 'desc')
        ->take(200)
        ->get()
        ->toArray();

        //dd($allData);

        return response()->json($allData, 200);
    }

    // car
    public function car(Request $request){

        $start = $request->selectData['start_date'] ." ". $request->selectData['start_time'];
        $end = $request->selectData['end_date'] ." ". $request->selectData['end_time'];



        $bookingData = CarpoolBooking::with('car', 'bookby', 'driver')
            ->where('status', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->orderBy('car_id')
            ->get();


        // Booked Car ID 
        if($bookingData){
            $booked_car_id = [];
            foreach($bookingData as $item){
                array_push($booked_car_id, $item->car_id); 
            }
        }


        // car data
        $carData = CarpoolCar::where('status', 1)
            ->with('driver')
            ->where('temporary', 0)
            ->whereNotIn('id', $booked_car_id)
            ->get();


        // leave car data
        $leaveData = CarpoolLeaves::with('car','driver')
            ->whereHas('car', function($q){
                $q->where('status', 1);
            })
            ->whereNotIn('id', $booked_car_id)
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->get();
            

        // tempoprary car data
        $temporaryCarData = CarpoolCar::
            // ->whereHas('carLeave', function($q) use($booked_car_id){
            //     $q->whereNotIn('car_id', $booked_car_id);
            // })
            where('status', 1)
            ->where('temporary', 1)
            ->with('driver')
            ->whereNotIn('id', $booked_car_id)
            ->get();
      


        return response()->json(['cars'=> $carData, 'bookings'=> $bookingData, 'leave'=> $leaveData, 'temporary'=> $temporaryCarData]);


    }


    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'start'          =>  'required',
            'end'            =>  'required',
            'purpose'        =>  'required|max:500',
        ]);

       

    
        $car_id          = $request->car_id;
        $car_name        = $request->car_name;
        $purpose          = $request->purpose;
        $start            = $request->start;
        $end              = $request->end;

        // Checking Booked 
        $booked =    $this->CheckBookingHaveOrNot($car_id, $start, $end);

        $leave =    $this->CheckDriverLeaveOrNot($car_id, $start, $end);

        //dd($leave);

        if($booked){
            return response()->json([
                'status'=>'error',
                'msg'=>'Car Was <b>Booked</b> At This Time !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

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

        

        $data = new CarpoolBooking();

        $data->car_id       = $car_id;
        $data->user_id       = Auth::user()->id;
        $data->start         = $start;
        $data->end           = $end;
        $data->purpose       = $purpose;
        $data->status        = 1;

        //For Line Msg Sending Variable
        $userName           = Auth::user()->name;
        $department         = Auth::user()->department;
        $startLine          = date("j-M-Y, g:i A", strtotime($start));
        $endLine            = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine        = str_replace('&', 'and', $purpose);
        //Send Line Message
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Car: $car_name,%0A Start: $startLine,%0A End: $endLine";
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
