<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Room\CommonFunctions;

class BookingController extends Controller
{
    use CommonFunctions;

    //data
    public function data(){

        $allData = CarpoolBooking::where('status', '1')
        ->with('car', 'bookby')
        ->orderBy('id', 'desc')
        ->take(500)
        ->get()
        ->toArray();

        //dd($allData);

        return response()->json($allData, 200);
    }

    // car
    public function car(Request $request){

        $start = $request->selectData['start_date'] ." ". $request->selectData['start_time'];
        $end = $request->selectData['end_date'] ." ". $request->selectData['end_time'];


        $bookingData = CarpoolBooking::with('car')->with('bookby', 'driver')
            ->where('status', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->orderBy('car_id')
            ->get();


        // Booked Car ID 
        if($bookingData){
            $booked_car_id = [];
            foreach($bookingData as $item){
                // Push All Room ID
                array_push($booked_car_id, $item->car_id); 
            }
        }

        //dd($start, $end);
        $carData = CarpoolCar::where('status', 1)
            ->with('driver')
            ->whereNotIn('id', $booked_car_id)
            ->get();
      

        //dd( $booked_car_id, $bookingData, $roomData);

        return response()->json(['cars'=> $carData, 'bookings'=> $bookingData]);


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

       

    
        $car_id          = $request->car_id;
        $car_name        = $request->car_name;
        $purpose          = $request->purpose;
        $start            = $request->start;
        $end              = $request->end;

        // Checking Booked 
        $booked =    $this->CheckBookingHaveOrNot($car_id, $start, $end);

        if($booked){
            return response()->json([
                'status'=>'error',
                'msg'=>'Car Was <b>Booked</b> At This Time !! &#128530;', 
                'icon'=>'warning'
            ]);
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
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $car_name,%0A Start: $startLine,%0A End: $endLine";
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
