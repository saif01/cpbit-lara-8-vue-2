<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Dependencies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareDependency;
use Auth;

class IndexController extends Controller
{
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareDependency::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);


    }


    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'name'      => 'required'
        ]);

        $data = new HardwareDependency();

    
        $data->name = $request->name;

        
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
        ]);

        $data = HardwareDependency::find($id);

        $data->name = $request->name;
        
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


    //destroy
    public function destroy($id){

        $data       = HardwareDependency::findOrFail($id);
        $success    = $data->delete();

        if($success){
            return response()->json(['success' => 'Successfully Deleted', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }
}
