<?php

namespace App\Http\Controllers\iVCA\User\Mro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\iVca\ivcaAuditMroToken;
use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Image;
use File;

use App\Models\iVca\ivcaAuditMroManufacturer; 


class AuditController extends Controller
{
   

    // tempalte_data
    public function tempalte_data(Request $request){

       
        $token = $request->token;
        // dd($token);

        $date = date('Y-m-d');
        $data = ivcaAuditMroToken::with('schedule')->where('token', $token)->where('date', $date)->first();

        
        if($data){

            // $schedule_id =  $data->schedule_id;
            // $vendor_id   =  $data->vendor_id;
            // $template =  $data->template;

            // if( $template == 'mro_manufacturer' ){

            //     $templateData = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();

            // }elseif( $template == 'mro_importer' ){

            //     $templateData = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();

            // }elseif( $template == 'mro_retailer' ){

            //     $templateData = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();

            // }else{
            //     return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Template not found'], 200);
            // }
           





            
            return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Start Vendor Audit'], 200);
        }else{
            return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'Sorry! Token not found'], 200);
        }


    }


}
