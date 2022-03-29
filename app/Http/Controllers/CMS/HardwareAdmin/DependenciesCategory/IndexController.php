<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\DependenciesCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategoryDependence;
use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\Cms\Hardware\HardwareDependency;

use Auth;

class IndexController extends Controller
{
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareCategoryDependence::with('makby','category','dependent')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);


            if($allData){
                $dep_id = [];
                foreach($allData as $item){
                    array_push($dep_id, explode(',', $item->dep_id)); 
                }
            }

            dd($dep_id);

        return response()->json($allData, 200);

    }


    // get category
    public function category(){
        $allData = HardwareCategory::get();

        return response()->json($allData, 200);
    }

    public function categoryDependency(){
        $allData = HardwareDependency::get();

        return response()->json($allData, 200);
    }


    // store
    public function store(Request $request){
        //dd($request);

        //Validate
        $this->validate($request,[
            'cat_id'        => 'required',
            'field_id'      => 'required'
        ]);

     
        $data = HardwareCategory::find($request->cat_id);

        $success = $data->catdep()->sync($request->field_id);

        // dd($success,  $data);


        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }
}
