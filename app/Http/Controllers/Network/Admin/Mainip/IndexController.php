<?php

namespace App\Http\Controllers\Network\Admin\Mainip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Network\NetworkMainip;
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

        $allData = NetworkMainip::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }




    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'ip'        => 'required|unique:network_mainips|max:50',
            'name'      => 'required|max:30'
        ]);

        $data = new NetworkMainip();

        if( empty($request->pingType) ){
            $start  =   $request->start ?? '01:01:01';
            $end    =   $request->end ?? '23:59:59';
        }
        elseif($request->pingType == 'OfficeTime'){
            $start  = '09:00:00';
            $end    = '18:00:00';
        }
        elseif($request->pingType == 'fullDay'){
            $start  = '06:00:00';
            $end    = '18:00:00';
        }
        elseif($request->pingType == 'fullNight'){
            $start  = '18:00:00';
            $end    = '06:00:00';
        }
        elseif($request->pingType == 'dayNight'){
            $start  = '01:01:01';
            $end    = '23:59:59';
        }

        $data->ip         = $request->ip;
        $data->name       = $request->name;
        $data->start      = $start;
        $data->end        = $end;
        
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
            'ip'        => 'required|max:50|unique:network_mainips,ip,'.$id,
            'name'      => 'required|max:30'
        ]);

        $data = NetworkMainip::find($id);

        if( empty($request->pingType) ){
            $start  =   $request->start ?? '01:01:01';
            $end    =   $request->end ?? '23:59:59';
        }
        elseif($request->pingType == 'OfficeTime'){
            $start  = '09:00:00';
            $end    = '18:00:00';
        }
        elseif($request->pingType == 'fullDay'){
            $start  = '06:00:00';
            $end    = '18:00:00';
        }
        elseif($request->pingType == 'fullNight'){
            $start  = '18:00:00';
            $end    = '06:00:00';
        }
        elseif($request->pingType == 'dayNight'){
            $start  = '01:01:01';
            $end    = '23:59:59';
        }

        $data->ip         = $request->ip;
        $data->name       = $request->name;
        $data->start      = $start;
        $data->end        = $end;

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

        $data       = NetworkMainip::findOrFail($id);
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

        $data       =  NetworkMainip::find($id);
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
        $allActiveIp = NetworkMainIp::where('status', 1)->get();

        $allPing = $this->AllPing($allActiveIp);

        if($allPing){
            response()->json('success', 200);
        }
    }



    public function test(){
        
        $cmd = 'ping -n 2 127.0.0.1';
        $output = exec($cmd);

        $testing=[];

        while (@ ob_end_flush()); 
        
        echo '<pre>';
        $proc = popen($cmd, 'r');
        while (!feof($proc))
        {
            //array_push($testing,fread($proc, 4096));
            echo fread($proc, 4096);
            
            @ flush();
        }

        
        echo '<pre>';





    }



    
}
