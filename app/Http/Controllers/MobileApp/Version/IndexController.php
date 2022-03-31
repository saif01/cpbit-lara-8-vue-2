<?php

namespace App\Http\Controllers\MobileApp\Version;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MobileApp\MobileAppVersion;
use Auth;
use DB;

class IndexController extends Controller
{

    // apiVersion
    public function apiVersion(Request $request){

        $name = $request->appname ?? null;

        // // Check Data Table exist
        $tblNotFound = DB::getSchemaBuilder()->hasTable('mobile_app_versions');
        //dd($tblNotFound); 
        if(!$tblNotFound){
            $allData = [
                'status'  =>  'error',
                'code'    =>  404,
                'data'    =>  '',
                'message' => 'Data Table not found',
            ];
            return response()->json($allData, 200); 
        }

        $data = MobileAppVersion::where('status', 1)
            ->where('name', $name)
            ->first();

        if($data){
            $allData =[
                'status'    =>  'Success',
                'code'      =>  200,
                'data'      =>  $data->version,
                'message'   =>  'Successfully data found',
                
            ];
        }else{
            $allData =[
                'status'  =>  'error',
                'code'    =>  500,
                'data'    =>  '',
                'message' => 'Server Error',
            ];
        }
       
        return response()->json($allData, 200);
    }


    
    //index
    public function index(){

      

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = MobileAppVersion::with('makby')
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
            'name'     => 'required|string|max:100|unique:mobile_app_versions',
            'version'  => 'required'
        ]);

        $data = new MobileAppVersion();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->version    = $request->version;
        $data->status     = 1;
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
            'name'     => 'required|string|max:1000|unique:mobile_app_versions,name,'.$id,
            'version'  => 'required'
        ]);

        $data = MobileAppVersion::find($id);

      
        $data->name       = $request->name;
        $data->version    = $request->version;
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
        $data       =  MobileAppVersion::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  MobileAppVersion::find($id);
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