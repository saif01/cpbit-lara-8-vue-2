<?php

namespace App\Http\Controllers\Network\Admin\Subip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Network\NetworkSubip;
use App\Models\Network\NetworkGroupName;
use App\Http\Controllers\Network\Admin\CommonFunctions;
use Auth;

class IndexController extends Controller
{
    use CommonFunctions;


    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $sort_by_name   = Request('sort_by_name', '');

        $dataQuery = NetworkSubip::with('makby');
        // show by group name
        if(!empty( $sort_by_name )){
           $dataQuery->where('group_name', $sort_by_name); 
        }
            
        $allData = $dataQuery->orderBy($sort_field, $sort_direction)
        ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // get groupName
    public function groupName(){

        $allData = NetworkGroupName::select('name')->get();

        return response()->json($allData, 200);

    }


    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'ip'         => 'required|unique:network_mainips|max:50',
            'name'       => 'required|max:30',
            'group_name' => 'required',
        ]);

        $data = new NetworkSubip();

        $data->ip           = $request->ip;
        $data->name         = $request->name;
        $data->group_name   = $request->group_name;
        
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
            'ip'         => 'required|max:50|unique:network_mainips,ip,'.$id,
            'name'       => 'required|max:30',
            'group_name' => 'required',
        ]);

        $data = NetworkSubip::find($id);

        $data->ip           = $request->ip;
        $data->name         = $request->name;
        $data->group_name   = $request->group_name;

        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    //Delete
    public function destroy($id){

        $data       = NetworkSubip::findOrFail($id);
        $success    = $data->delete();

        if($success){
            return response()->json(['msg'=>'Deleted Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data is not deleted !!'
            ], 422);
        }
    }




    // change status
    public function status($id){

        $data       =  NetworkSubip::find($id);
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


    // single ip ping
    public function singleIpPing(){

        $ip = Request('ip');

        $singlePing = $this->SinglePing($ip);

        if($singlePing == 'Online'){
            return response()->json('success', 200);
        }else if($singlePing == 'Offline'){
            return response()->json('error', 200);
        }
        
    }


    // ping All
    public function pingAll(){
        $allActiveIp = NetworkSubip::where('status', 1)->get();

        $allPing = $this->AllPing($allActiveIp);

        if($allPing){
            response()->json('success', 200);
        }
    }



    
}
