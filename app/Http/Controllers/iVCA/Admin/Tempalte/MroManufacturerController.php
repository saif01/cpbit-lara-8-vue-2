<?php

namespace App\Http\Controllers\iVCA\Admin\Tempalte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaTemplateMroManufacturer;
use Auth;

class MroManufacturerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //data
    public function data(){
        $allData = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }

    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'storage_1'     => 'required|string|max:1000',
            'storage_2'     => 'required|string|max:1000',
            'storage_3'     => 'required|string|max:1000',
            'storage_4'     => 'required|string|max:1000',

            'production_qs_1'     => 'required|string|max:1000',
            'production_qs_2'     => 'required|string|max:1000',
            'production_qs_3'     => 'required|string|max:1000',
            'production_qs_4'     => 'required|string|max:1000',

            'safety_1'     => 'required|string|max:1000',
            'safety_2'     => 'required|string|max:1000',
            'safety_3'     => 'required|string|max:1000',
            'safety_4'     => 'required|string|max:1000',

            'env_sur_con_1'     => 'required|string|max:1000',
            'env_sur_con_2'     => 'required|string|max:1000',
            'env_sur_con_3'     => 'required|string|max:1000',
            'env_sur_con_4'     => 'required|string|max:1000',

            'equipment_1'     => 'required|string|max:1000',
            'equipment_2'     => 'required|string|max:1000',
            'equipment_3'     => 'required|string|max:1000',

            'cooperate_1'     => 'required|string|max:1000',
            'cooperate_2'     => 'required|string|max:1000',
            'cooperate_3'     => 'required|string|max:1000',


        ]);


       // $tblCheck = ivcaTemplateMroManufacturer::exists();

        $dataCount = ivcaTemplateMroManufacturer::count();

        if($dataCount > 0){
            $data = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();
        }else{
            $data = new ivcaTemplateMroManufacturer();
        }

        
    
        $data->storage_1        = $request->storage_1;
        $data->storage_2        = $request->storage_2;
        $data->storage_3        = $request->storage_3;
        $data->storage_4        = $request->storage_4;

        $data->production_qs_1    = $request->production_qs_1;
        $data->production_qs_2    = $request->production_qs_2;
        $data->production_qs_3    = $request->production_qs_3;
        $data->production_qs_4    = $request->production_qs_4;

        $data->safety_1         = $request->safety_1;
        $data->safety_2         = $request->safety_2;
        $data->safety_3         = $request->safety_3;
        $data->safety_4         = $request->safety_4;

        $data->env_sur_con_1    = $request->env_sur_con_1;
        $data->env_sur_con_2    = $request->env_sur_con_2;
        $data->env_sur_con_3    = $request->env_sur_con_3;
        $data->env_sur_con_4    = $request->env_sur_con_4;

        $data->equipment_1      = $request->equipment_1;
        $data->equipment_2      = $request->equipment_2;
        $data->equipment_3      = $request->equipment_3;

        $data->cooperate_1      = $request->cooperate_1;
        $data->cooperate_2      = $request->cooperate_2;
        $data->cooperate_3      = $request->cooperate_3;

        $data->status           = null;
        $data->created_by       = Auth::user()->id;
        $success                = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }




}
