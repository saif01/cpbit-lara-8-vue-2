<?php

namespace App\Http\Controllers\iTemp\User\Allemployee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\iTemp\itempEmployeeTemp;
use App\Models\iTemp\itempEmployee;
use App\Models\iTemp\itempCheckpoint;

use Carbon\Carbon;

use Auth;

class IndexController extends Controller
{
    public function index(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = itempEmployee::with('temp')
            // ->whereHas('temp', function($q){
            //     $q->where('date', Carbon::now()->format('Y-m-d'));
            // })
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }


    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'today_temp'   => 'required',
            'checkPoint'   => 'required',
            'remarks_all'  => 'nullable',
        ]);
        

        $data2 = itempEmployeeTemp::where('emp_id', $request->id)->where('date', Carbon::now()->format('Y-m-d'))->first();

        if(!empty($data2)){
            
            if($data2->temp_2 === null){

                $data2->temp_2          = $request->today_temp;
                $data2->temp_2_location = $request->checkPoint;
                $data2->temp_2_time     = Carbon::now();
                $data2->temp_2_by_name   = Auth::user()->id;
                $data2->temp_final      = $request->today_temp;

            }else if($data2->temp_3 === null){

                $data2->temp_3          = $request->today_temp;
                $data2->temp_3_location = $request->checkPoint;
                $data2->temp_3_time     = Carbon::now();
                $data2->temp_3_by_name   = Auth::user()->id;
                $data2->temp_final      = $request->today_temp;

            }else if($data2->temp_4 === null){

                $data2->temp_4          = $request->today_temp;
                $data2->temp_4_location = $request->checkPoint;
                $data2->temp_4_time     = Carbon::now();
                $data2->temp_4_by_name   = Auth::user()->id;
                $data2->temp_final      = $request->today_temp;
                    
            }else if($data2->temp_5 === null){

                $data2->temp_5          = $request->today_temp;
                $data2->temp_5_location = $request->checkPoint;
                $data2->temp_5_time     = Carbon::now();
                $data2->temp_5_by_name   = Auth::user()->id;
                $data2->temp_final      = $request->today_temp;

            }

            
        }else{
            $data = new itempEmployeeTemp();
            $data->temp_1          = $request->today_temp;
            $data->temp_1_location = $request->checkPoint;
            $data->temp_1_time     = Carbon::now();
            $data->temp_1_by_name  = Auth::user()->id;
            $data->temp_final      = $request->today_temp;
            $data->id_number    =  $request->id_number;
            $data->emp_id       =  $request->id;
            $data->name         =  $request->name;
            $data->department   =  $request->department;
            $data->date         =  Carbon::now()->format('Y-m-d');
            $data->remarks      =  $request->remarks_all;
            $success            = $data->save();

        }

        $data2->id_number    =  $request->id_number;
        $data2->emp_id       =  $request->id;
        $data2->name         =  $request->name;
        $data2->department   =  $request->department;
        $data2->date         =  Carbon::now()->format('Y-m-d');
        $data2->remarks      =  $request->remarks_all;
        $success             = $data2->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }



    public function check_point(){

        $allData = itempCheckpoint::select('name')->get();

        return response()->json($allData, 200);

    }
}
