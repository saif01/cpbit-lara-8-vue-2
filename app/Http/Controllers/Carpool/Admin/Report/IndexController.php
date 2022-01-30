<?php

namespace App\Http\Controllers\Carpool\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolBooking;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolDriver;
use App\Models\Carpool\CarpoolDriverLeave;
use App\Models\Carpool\CarpoolCarMaintenance;
use App\Models\Carpool\CarpoolCarRequisition;
use App\Models\User;

use Carbon\Carbon;

class IndexController extends Controller
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

        $allQuery =  CarpoolBooking::with('car', 'bookby', 'driver');


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

        $allData =  $allQuery ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    //All Data
    // public function index(){

    //     $cars = CarpoolCar::get();

    //     if(request()->ajax())
    //     {


    //         $car_id     = request()->src_car_id;
    //         $reportType = request()->reportType;
    //         $from_date  = request()->from_date;
    //         $to_date    = request()->to_date;


    //         if( !empty($reportType) )
    //         {

    //             //How Many days Back From Today
    //             $date = Carbon::today()->subDays($reportType);

    //             if( $car_id ){
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')
    //                     ->where('car_id', $car_id)
    //                     ->whereDate('start', '>=', $date)
    //                     ->whereDate('end', '<=', Carbon::today())
    //                     ->latest();
    //             }else{
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')
    //                     ->whereDate('start', '>=', $date)
    //                     ->whereDate('end', '<=', Carbon::today())
    //                     ->latest();
    //             }

    //         }
    //         elseif( !empty($from_date)  &&  !empty($to_date) )
    //         {

    //             if( $car_id ){
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')
    //                     ->where('car_id', $car_id)
    //                     ->whereDate('start', '>=', $from_date)
    //                     ->whereDate('end', '<=', $to_date)
    //                     ->latest();
    //             }else{
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')
    //                     ->whereDate('start', '>=', $from_date)
    //                     ->whereDate('end', '<=', $to_date)
    //                     ->latest();
    //             }

    //         }
    //         else
    //         {
    //             if($car_id){
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')::where('car_id', $car_id)
    //                 ->latest();
    //             }else{
    //                 $data = CarpoolBooking::with('car', 'user', 'driver')->latest();
    //             }

    //         }


    //         return DataTables::of($data)

    //             ->addColumn('carData', function($data){
    //                 if($data->car){
    //                     return $data->car->name.' || '.$data->car->number;
    //                 }else{
    //                     return '<span class="text-danger">Not-Found !!</span>';
    //                 }


    //             })

    //             ->addColumn('mileage', function($data){
    //                 return $data->start_mileage.' || '.$data->end_mileage;

    //             })

    //             ->addColumn('userData', function($data){
    //                 if($data->user){
    //                     return '<button id="'.$data->user_id.'" class="userInfoDetail btn btn-info btn-sm" >'.$data->user->name.'</button>';
    //                 }else{
    //                     return '<span class="text-danger">Not-Found !!</span>';
    //                 }

    //             })

    //             ->addColumn('driverData', function($data){
    //                 if($data->driver){
    //                     return '<button id="'.$data->driver->id.'" class="driverInfoDetail btn btn-info btn-sm" >'.$data->driver->name.'</button>';
    //                 }else{
    //                     return '<span class="text-danger">Not-Found !!</span>';
    //                 }
    //             })


    //             ->addColumn('startDate', function($data){
    //                 return date("F j, Y, g:i a", strtotime($data->start));
    //             })

    //             ->addColumn('endDate', function($data){
    //                 return date("F j, Y, g:i a", strtotime($data->end));
    //             })

    //             ->addColumn('statusDate', function($data){
    //                 if($data->status == 1){
    //                     return '<span class="text-success">Booked</span>';
    //                 }else{
    //                     return '<span class="text-danger">Canceled</span>';
    //                 }
    //             })

    //             ->rawColumns(['carData', 'userData', 'driverName', 'startDate', 'endDate', 'statusDate', 'driverData'])
    //             ->make(true);
    //     }


    //     return view('admin.carpool.reports.all', compact('cars') );
    // }


    //DriverLeave
    public function DriverLeave(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolDriverLeave::with('car', 'driver')
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

        $allData = CarpoolCarMaintenance::with('car', 'driver')
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

        $allData = CarpoolCarRequisition::with('car', 'driver')
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
            ->select('name', 'department', 'business_unit', 'personal_contact', 'image')
            ->first();

        return response()->json($allData, 200);

    }
    




    // car data

    public function CarData(){

        $allData = CarpoolCar::
        where("status", 1)
        ->select('id', 'name', 'number')
        ->get();

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
