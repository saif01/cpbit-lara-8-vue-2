<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\Cms\Hardware\HardwareComplain;

class ModifyController extends Controller
{
    //category
    public function category(){
        $allData = HardwareCategory::with('acsosoris', 'subcat')->orderBy('name')->get();
        return response()->json($allData);
    }

    // category_modify
    public function category_modify(Request $request){

        //Validate
        $this->validate($request,[
            'cat_id'   => 'required',
            'subcat_id'   => 'required',
        ]);

        $data = HardwareComplain::find($request->id);

        if($data){

            $data->cat_id       = $request->cat_id;
            $data->subcat_id    = $request->subcat_id;
            $success            = $data->save();
           
            if($success){
                return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
            }else{
                return response()->json([
                    'msg' => 'Data not save in DB !!'
                ], 422);
            }
    
        }

    }
}
