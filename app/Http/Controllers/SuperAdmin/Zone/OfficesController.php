<?php

namespace App\Http\Controllers\SuperAdmin\Zone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SuperAdmin\Zone;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;
use App\Models\User;

class OfficesController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ZoneOffice::with('makby')
            ->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // allzones
    public function allzones(){

        $allData = Zone::where('status', 1)
            ->orderBy('name')
            ->get();

        return response()->json($allData, 200);
    }

    // alloffices
    public function alloffices(){

        $allData = User::where('status', 1)
            ->select('zone_office')
            ->orderBy('zone_office')
            ->distinct()
            ->get();

        return response()->json($allData, 200);
    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'name'     => 'required|unique:zone_offices',
            'offices'  => 'required'
        ]);

        $data = new ZoneOffice();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->offices    = implode(",", $request->offices);
        $data->status     = 1;
        $data->created_by = Auth::user()->id;
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
            'name'     => 'required|string|max:1000|unique:zone_offices,name,'.$id,
            'offices'  => 'required'
        ]);

        $data = ZoneOffice::find($id);

      
        $data->name       = $request->name;
        $data->offices    = implode(",", $request->offices);
        $data->status     = 1;
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

    // destroy_temp
    public function destroy_temp($id)
    {
        $data       =  ZoneOffice::find($id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);
      
    }

    // destroy
    public function destroy($id)
    {
        $data       =  ZoneOffice::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  ZoneOffice::find($id);
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
