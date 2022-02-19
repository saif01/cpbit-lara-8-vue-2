<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Others\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\Cms\Hardware\HardwareAcsosoris;
use Auth;

class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareCategory::with('makby', 'acsosoris')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // acsosoris
    public function acsosoris(){
        $allData = HardwareAcsosoris::select('id','name')->orderBy('name')->get();
        return response()->json($allData);
    }

   
    // store
    public function store(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100|unique:hardware_categories',
            'label'    => 'nullable|string|max:100',
        ]);

        $data = new HardwareCategory();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->label      = $request->label;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

        // Update Acsosoris
        if($request->acsosoris){
            $data->acsosoris()->sync($request->acsosoris);
        }

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
            'name'     => 'required|string|max:1000|unique:hardware_categories,name,'.$id,
            'label'    => 'nullable|string|max:100',
        ]);

        $data = HardwareCategory::find($id);

      
        $data->name       = $request->name;
        $data->label      = $request->label;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

        // Update Acsosoris
        if($request->acsosoris){
            $data->acsosoris()->sync($request->acsosoris);
        }

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
        $data       =  HardwareCategory::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  HardwareCategory::find($id);
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