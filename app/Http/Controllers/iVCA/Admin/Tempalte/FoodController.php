<?php

namespace App\Http\Controllers\iVCA\Admin\Tempalte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaTemplateFood; 
use Auth;

class FoodController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //data
    public function data(){
        $allData = ivcaTemplateFood::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }

    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        // Validate
        $this->validate($request,[
            'building_facilities_a'     => 'required|string|max:1000',
            'building_facilities_b'     => 'required|string|max:1000',
            'building_facilities_c'     => 'required|string|max:1000',
            'building_facilities_d'     => 'required|string|max:1000',
            'building_facilities_e'     => 'required|string|max:1000',

            'equipment_a'     => 'required|string|max:1000',
            'equipment_b'     => 'required|string|max:1000',
            'equipment_c'     => 'required|string|max:1000',

            'personnel_a'     => 'required|string|max:1000',
            'personnel_b'     => 'required|string|max:1000',
            'personnel_c'     => 'required|string|max:1000',

            'raw_materials_a'     => 'required|string|max:1000',
            'raw_materials_b'     => 'required|string|max:1000',
            'raw_materials_c'     => 'required|string|max:1000',
            'raw_materials_d'     => 'required|string|max:1000',
            'raw_materials_e'     => 'required|string|max:1000',

            'production_a'     => 'required|string|max:1000',
            'production_b'     => 'required|string|max:1000',
            'production_c'     => 'required|string|max:1000',
            'production_d'     => 'required|string|max:1000',
            'production_e'     => 'required|string|max:1000',
            'production_f'     => 'required|string|max:1000',

            'records_a'     => 'required|string|max:1000',
            'records_b'     => 'required|string|max:1000',
            'records_c'     => 'required|string|max:1000',
            'records_d'     => 'required|string|max:1000',

            'labeling_a'     => 'required|string|max:1000',
            'labeling_b'     => 'required|string|max:1000',
            'labeling_c'     => 'required|string|max:1000',


        ]);


       // $tblCheck = ivcaTemplateFood::exists();

        $dataCount = ivcaTemplateFood::count();

        if($dataCount > 0){
            $data = ivcaTemplateFood::orderBy('id', 'desc')->first();
        }else{
            $data = new ivcaTemplateFood();
        }

        
    
        $data->building_facilities_a        = $request->building_facilities_a;
        $data->building_facilities_b        = $request->building_facilities_b;
        $data->building_facilities_c        = $request->building_facilities_c;
        $data->building_facilities_d        = $request->building_facilities_d;
        $data->building_facilities_e        = $request->building_facilities_e;

        $data->equipment_a        = $request->equipment_a;
        $data->equipment_b        = $request->equipment_b;
        $data->equipment_c        = $request->equipment_c;

        $data->personnel_a        = $request->personnel_a;
        $data->personnel_b        = $request->personnel_b;
        $data->personnel_c        = $request->personnel_c;

        $data->raw_materials_a        = $request->raw_materials_a;
        $data->raw_materials_b        = $request->raw_materials_b;
        $data->raw_materials_c        = $request->raw_materials_c;
        $data->raw_materials_d        = $request->raw_materials_d;
        $data->raw_materials_e        = $request->raw_materials_e;

        $data->production_a        = $request->production_a;
        $data->production_b        = $request->production_b;
        $data->production_c        = $request->production_c;
        $data->production_d        = $request->production_d;
        $data->production_e        = $request->production_e;
        $data->production_f        = $request->production_f;

        $data->records_a        = $request->records_a;
        $data->records_b        = $request->records_b;
        $data->records_c        = $request->records_c;
        $data->records_d        = $request->records_d;

        $data->labeling_a        = $request->labeling_a;
        $data->labeling_b        = $request->labeling_b;
        $data->labeling_c        = $request->labeling_c;

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

