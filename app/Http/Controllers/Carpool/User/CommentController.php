<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;

class CommentController extends Controller
{

    // get uncommented data 
    public function index(){
       
        $allData = CarpoolBooking::with('car')
            ->where('status', '1')
            ->where('user_id',  Auth::user()->id)
            ->whereNull('comit_st')
            ->where('start', '<=', Carbon::now())
            ->orderBy('start', 'asc')
            ->get();

        return response()->json($allData, 200);
    }


    // comment_count
    public function comment_count(){
       
        $allData = CarpoolBooking::where('user_id', Auth::user()->id )
            ->where('status', '1')
            ->whereNull('comit_st')
            ->where('end', '<=', Carbon::now())
            ->count();

        return response()->json($allData, 200);
    }


    // update on booking table 
    public function update_comment(Request $request){

        //Validate
        $this->validate($request,[
            'start_mileage' => 'nullable',
            'end_mileage'   => 'nullable',
            'gas'           => 'nullable',
            'octane'        => 'nullable',
            'toll'          => 'nullable',
            'rating'        => 'nullable'
        ]);

        $data = CarpoolBooking::find(Request('id'));

        //dd($data);

    
        $data->start_mileage  = $request->start_mileage;
        $data->end_mileage    = $request->end_mileage;
        $data->gas            = $request->gas;
        $data->octane         = $request->octane;
        $data->toll           = $request->toll;
        $data->driver_rating  = $request->driver_rating;

        $data->km = $request->end_mileage - $request->start_mileage;
        $data->cost = $request->gas + $request->octane + $request->toll;

        if(Request('submit') == 2){
            $data->comit_st  = 1;
        }
        
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }
    }


    // get previous comment data
    public function PrevComment($id){
        $allData = CarpoolBooking::where('id', '=', $id) 
            ->select('start_mileage', 'end_mileage', 'toll', 'gas', 'octane', 'id', 'driver_rating')
            ->first();

            return response()->json($allData, 200);
            //dd($id, $allData);
    }


    // get car data
    public function carData($car_id){

        $allData = CarpoolCar::where('id', '=', $car_id)->first();

        return response()->json($allData, 200);
    }
}
