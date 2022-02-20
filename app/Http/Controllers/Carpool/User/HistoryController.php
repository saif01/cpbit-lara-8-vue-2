<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolDriver;
use App\Models\Carpool\CarpoolLeaves;
use App\Models\User;

use Carbon\Carbon;
use Auth;

class HistoryController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_car    = Request('sort_by_car', '');
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  CarpoolBooking::with('car', 'bookby', 'driver')
        ->where('user_id', Auth::user()->id);


        // sort by car
        if(!empty($sort_by_car)){
            $allQuery->where('car_id', $sort_by_car );
        } 
        
        // sort_by_day

        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('start', '>=', $date );
        }
        
        
        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery ->whereDate('start', '>=', $sort_by_startDate)
                      ->whereDate('end', '<=', $sort_by_endDate);
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }



    //DriverLeave
    public function DriverLeave(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolLeaves::with('car', 'driver')
            ->where('type', 'lev')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }


    //Car Maintenance
    public function CarMaintenance(){

        //return view('admin.carpool.reports.car.maintenance');


        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolLeaves::with('car', 'driver')
            ->where('type', 'mant')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }


    //Car Requisition
    public function CarRequisition(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolLeaves::with('car', 'driver')
            ->where('type', 'req')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }



    // driver info
    public function CarDriver($id){

        $allData = CarpoolDriver::
            where('id', '=', $id)
            ->select('name', 'contact', 'license', 'nid', 'image')
            ->first();

        return response()->json($allData, 200);


    }


    // bookbyUser info
    public function bookbyUser($id){

        $allData = User::
            where('id', '=', $id)
            ->first();

        return response()->json($allData, 200);

    }
    




    // car data

    public function CarData(){

        $allData = CarpoolCar::
        where("status", 1)
        ->select('id', 'name', 'number')
        ->get(); 

        // Custom Field Data Add
        $custom = collect( [['id' => '', 'name' => 'Car', 'number' => 'All']] );
        $allData = $custom->merge($allData);

        return response()->json($allData, 200);
    }


    // sort by car
    public function sortByCar($id){


        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolBooking::with('car', 'bookby', 'driver')
            // ->whereHas('car', function($query){
            //         // Check User Role
            //         $query->where('id', $id);
            //     })
            ->where('car_id', '=', $id )
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }




}

