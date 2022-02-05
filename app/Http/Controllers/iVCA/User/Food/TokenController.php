<?php

namespace App\Http\Controllers\iVCA\User\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaAuditFoodToken;
use App\Models\iVca\ivcaAuditMroImporter; 
use App\Models\iVca\ivcaAuditMroManufacturer;
use App\Models\iVca\ivcaAuditMroRetailer; 
use Auth;
use App\Models\User;

class TokenController extends Controller
{
    // Token create
    public function create(Request $request){

        $scheduleId = $request->scheduleId;
        $vendorId = $request->vendorId;

        // request data empty
        if( empty($scheduleId) || empty($vendorId) ){
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Somthing going wrong'], 200);
        }

        $year = date('y');
        $month = date('m');
        $day = date('d');
        // Generate Custom Random Number
        $randNumber = $this->generatePin(4);
        $finalToken = $year.$month.$randNumber;

       // dd($scheduleId, $vendorId, $randomId, $finalToken);

       // Role Check
       $checkUserRole = User::whereHas('ivca_roles', function($query){
           $query->whereIn('name', ['Admin', 'Auditor', 'Food']);
       })->count();

       if($checkUserRole > 0){

        $data = new ivcaAuditFoodToken();

        $data->token        = $finalToken;
        $data->schedule_id  = $scheduleId;
        $data->vendor_id    = $vendorId;
        $data->date         = date('Y-m-d');
        $data->template     = 'food';
        $data->status       = 1;
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();

      
        return response()->json([ 'token'=>$finalToken, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Token has been Generated'], 200);

       }else{
        return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! You have no access'], 200);
       }

        
    }

    // Generate token
    public function generatePin($number) {
        // Generate set of alpha characters
        $alpha = array();
        for ($u = 65; $u <= 90; $u++) {
            // Uppercase Char
            array_push($alpha, chr($u));
        }
    
        // Just in case you need lower case
        // for ($l = 97; $l <= 122; $l++) {
        //    // Lowercase Char
        //    array_push($alpha, chr($l));
        // }
    
        // Get random alpha character
        $rand_alpha_key = array_rand($alpha);
        $rand_alpha = $alpha[$rand_alpha_key];
    
        // Add the other missing integers
        $rand = array($rand_alpha);
        for ($c = 0; $c < $number - 1; $c++) {
            array_push($rand, mt_rand(0, 9));
            shuffle($rand);
        }
    
        return implode('', $rand);
    }

    // Token check
    public function check(Request $request){

        // dd($request); 

        //Validate
        $this->validate($request,[
            'token'     => 'required',
        ]);

        $id    = $request->id;
        $token = $request->token;
        

        $date = date('Y-m-d');
        $data = ivcaAuditFoodToken::where('id', $id)->where('token', $token)->where('date', $date)->first();

        
        if($data){

            // $schedule_id =  $data->schedule_id;
            // $vendor_id   =  $data->vendor_id;
            $token   =  $data->token;
            
            return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Start Vendor Audit'], 200);
        }else{
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Token not found'], 200);
        }


    }

    // Token check by user
    public function check_by_user(Request $request){

        // dd($request->vendor_id, $request->all());  

        //Validate
        $this->validate($request,[
            'token'     => 'required',
        ]);

        $token = $request->token;
        $vendor_id = $request->vendor_id;
        

        $date = date('Y-m-d');
        $data = ivcaAuditFoodToken::where('token', $token)
        ->where('date', $date)
        ->where('vendor_id', $vendor_id)->first();

        
        if($data){

            $template   =  $data->template;
            $token      =  $data->token;

            // Template not selected
            if( empty($template) ){
                return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Template not selected'], 200); 
            }
            // Everything ok
            return response()->json([ 'token'=>$token, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Start Vendor Audit'], 200);
        }else{
            return response()->json([ 'status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Token not found'], 200);
        }


    }


    // Token data
    public function data(Request $request){

       
        $token = $request->token;
        // dd($token);

        $date = date('Y-m-d');
        $data = ivcaAuditFoodToken::where('token', $token)->where('date', $date)->first();

        
        if($data){

            // $schedule_id =  $data->schedule_id;
            // $vendor_id   =  $data->vendor_id;
            // $token   =  $data->token;
            
            return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Start Vendor Audit'], 200);
        }else{
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Token not found'], 200);
        }


    }


    // Tempplate_update
    public function tempplate_update(Request $request){

        $token    = $request->token;
        $template = $request->template;

        if(empty($token) || empty($template)){
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Somthing going wrong'], 200);
        }
        // dd($token);

        $date = date('Y-m-d');
        $data = ivcaAuditFoodToken::where('token', $token)->where('date', $date)->first();


        if($data){

            // $schedule_id =  $data->schedule_id;
            // $vendor_id   =  $data->vendor_id;
            $data->template = $template;
            $success = $data->save();

            if($template == 'mro_manufacturer'){

                // save data in auditor table
                $data2 = new ivcaAuditMroManufacturer();
                $data2->token        = $data->token;
                $data2->vendor_id    = $data->vendor_id;
                $data2->token_id     = $data->id;
                $data2->schedule_id  = $data->schedule_id;
                $data2->date         = $data->date;
                $data2->type         = 'Auditor';
                $data2->created_by   = Auth::user()->id;
                $data2->save();

            }elseif($template == 'mro_importer'){

                // save data in auditor table
                $data2 = new ivcaAuditMroImporter();
                $data2->token        = $data->token;
                $data2->vendor_id    = $data->vendor_id;
                $data2->token_id     = $data->id;
                $data2->schedule_id  = $data->schedule_id;
                $data2->date         = $data->date;
                $data2->type         = 'Auditor';
                $data2->created_by   = Auth::user()->id;
                $data2->save();

            }elseif($template == 'mro_retailer'){

                // save data in auditor table
                $data2 = new ivcaAuditMroRetailer();
                $data2->token        = $data->token;
                $data2->vendor_id    = $data->vendor_id;
                $data2->token_id     = $data->id;
                $data2->schedule_id  = $data->schedule_id;
                $data2->date         = $data->date;
                $data2->type         = 'Auditor';
                $data2->created_by   = Auth::user()->id;
                $data2->save();

            }

            
            
            
            return response()->json([ 'token'=>$token, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Start Vendor Audit'], 200);
        }else{
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Token not found'], 200);
        }


    }
    


}
