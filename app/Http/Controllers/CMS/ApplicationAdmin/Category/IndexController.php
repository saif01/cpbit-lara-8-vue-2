<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationCategory;
use Auth;

class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ApplicationCategory::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100|unique:application_categories',
        ]);

        $data = new ApplicationCategory();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

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
            'name'     => 'required|string|max:1000|unique:application_categories,name,'.$id,
        ]);

        $data = ApplicationCategory::find($id);

      
        $data->name       = $request->name;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    

    // destroy
    public function destroy($id)
    {
        $data       =  ApplicationCategory::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  ApplicationCategory::find($id);
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
}