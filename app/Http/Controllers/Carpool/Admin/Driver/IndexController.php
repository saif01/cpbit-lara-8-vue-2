<?php

namespace App\Http\Controllers\Carpool\Admin\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolDriver;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolLeaves;
use Illuminate\Support\Str;
use DataTables;
use Validator;
use Gate;
use Image;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Common\ImageUpload;
use DB;

class IndexController extends Controller
{
    use ImageUpload;

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolDriver::with('makby', 'car', 'active_leave')
            ->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // status
    public function status($id){

        $data       =  CarpoolCar::find($id);
        if($data){

           $status = $data->status;
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);
        }

    }

    // leave_status
    public function leave_status($id){

        $data       =  CarpoolLeaves::find($id);
        if($data){

           $status = $data->status;
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);
        }

    }

    // temporary
    public function temporary($id){

        $data       =  CarpoolDriver::find($id);
        if($data){

           $temporary = $data->temporary;
           
            if($temporary == 1){
                $data->temporary = 0;
            }else{
                $data->temporary = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }


    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'name'      => 'required',
            'contact'   => 'required',
            'nid'       => 'required',
            'license'   => 'required',
            'status'    => 'nullable'
        ]);

        $data = new CarpoolDriver();



        $imagePath      = 'images/carpool/driver/';
        // Save Image 
        $current_image  = $request->image; 
        if(!empty($current_image)){
            $imgName= $this->imageUplaodByName($current_image, null, $imagePath); 
            $data->image = $imgName;
        }

    
        $data->name         = $request->name; 
        $data->contact      = $request->contact;
        $data->car_id       = $request->car_id;
        $data->nid          = $request->nid;
        $data->license      = $request->license;
        $data->status       = $request->status;
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


     // update
    public function update(Request $request, $id){


        //Validate
        $this->validate($request,[
            'name'      => 'required',
            'contact'   => 'required',
            'nid'       => 'nullable',
            'license'   => 'nullable',
            'status'    => 'nullable'
        ]);

        $data = CarpoolDriver::find($id);


        $imagePath      = 'images/carpool/driver/';
        // Save Image 
        $current_image  = $request->image; 
        $old_image      = $data->image;
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }
      
        $data->name         = $request->name;
        $data->contact      = $request->contact;
        $data->car_id       = $request->car_id;
        $data->nid          = $request->nid;
        $data->license      = $request->license;
        $data->status       = $request->status;

        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    


    
    //DeadlineStore
    public function DeadlineStore(Request $request)
    {
         // update id start
        $id     =  $request->updateId1;
        $data   =  CarpoolDriver::find($id);
        //end update id

        $data->last_use=$request->last_use;
        $success = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    //DeadlineClear
    public function DeadlineClear($id){

        $data            = CarpoolDriver::find($id);
        $data->last_use  = null;
        $success         =$data->save();
        if($success){
                return 'ok';
        }else{
            return 'error';
        }

    }


    //Delete
    public function destroyTemp($id){

        $data               = CarpoolDriver::findOrFail($id);
        $data->delete_temp  = 1;
        $data->delete_by    = Auth::user()->id;
        $data->updated_at   = Carbon::now();
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Deleted Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data is not deleted !!'
            ], 422);
        }
    }


    // free_car_data
    public function free_car_data(){

        // car id in driver table
        $carId = CarpoolDriver::where('status', 1)->pluck('car_id');

        // carpool car
        $allData = CarpoolCar::whereNotIn('id', $carId)
        ->where('status', 1)
        ->select('id', 'name', 'number')
        ->get();

        //dd($carId, $allData);

        return response()->json($allData, 200);

    }


    // driver leave
    
    public function store_leave(Request $request){

        //Validate
        $this->validate($request,[
            'start_date'    => 'required',
            'start_time'    => 'required',
            'end_date'      => 'required',
            'end_time'      => 'required',
            'car_id'        => 'required',
            'driver_id'     => 'required',
            'type'          => 'required'
        ]);

        $data = new CarpoolLeaves();

        $start = $request->start_date ." ". $request->start_time;
        $end = $request->end_date ." ". $request->end_time;

       // Check
       $check = $this->leaveHave($start, $end, $request->driver_id);
       if($check){
        return response()->json(['msg'=>'Sorry! Date not avaiable &#128527;', 'icon'=>'error'], 201);
       }

    
        $data->start       = $start;
        $data->end         = $end;
        $data->car_id      = $request->car_id;
        $data->driver_id   = $request->driver_id;
        $data->type        = $request->type;
        $data->status      = 1;
        $data->created_by  =  Auth::user()->id;
        $success           = $data->save();

        if($success){
            return response()->json(['msg'=>'Saved Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // check Leave have
    public function leaveHave($start, $end, $driver_id){
        $data = CarpoolLeaves::where('status', '1')
        ->where('driver_id', $driver_id)
        ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
        ->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
    }

}

