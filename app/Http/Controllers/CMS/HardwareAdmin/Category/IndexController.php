<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategory;
use Auth;
 
class IndexController extends Controller
{
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareCategory::with('makby', 'dependences')
            //->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'name'      => 'required',
            'label'     => 'nullable',
        ]);

        $data = new HardwareCategory();

    
        $data->name = $request->name;

        if(empty($request->label)){
            $data->label = 'Enter Computer Name';
        }else{
            $data->label = $request->label;
        }
        
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
            'label'     => 'nullable',
        ]);

        $data = HardwareCategory::find($id);

        $data->name = $request->name;

        if(empty($request->label)){
            $data->label = 'Enter Computer Name';
        }else{
            $data->label = $request->label;
        }
        
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

        $data       = HardwareCategory::findOrFail($id);
        $success    = $data->delete();

        if($success){
            return response()->json(['success' => 'Successfully Deleted', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }


}
