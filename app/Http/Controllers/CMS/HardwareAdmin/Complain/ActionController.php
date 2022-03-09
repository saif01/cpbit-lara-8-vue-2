<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareRemarks;
use App\Http\Controllers\Common\ImageUpload;
use App\Http\Controllers\Common\Email\ScheduleEmailCmsHardware;
use App\Models\Cms\Hardware\HardwareDamageApply;
use Auth;

class ActionController extends Controller
{
    use ImageUpload;

    //action
    public function action($id){
        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'remarks', 'remarks.makby', 'remarks.mail', 'dam_apply', 'ho_remarks', 'ho_remarks.makby')  
        ->where('id', $id)
        ->first();

        return response()->json($allData);
    }


    // action_remarks
    public function action_remarks(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'comp_id'   => 'required',
            'process'   => 'required',
            'details'   => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;
        $process = $request->process;

        $data = new HardwareRemarks();

        // Store in Application Complain tbl
        $data2 = HardwareComplain::find($comp_id);
        $data2->process      = $process;

        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

        $data->comp_id      = $comp_id;
        $data->process      = $process;
        $data->details      = $request->details;
        $data->created_by   = Auth::user()->id;
       
        $success = $data->save();
        // Store in Application Complain tbl 
        $success2 = $data2->save();


        // Damageded or partial damaged
        if($process == 'Damaged' || $process == 'Partial Damaged'){
            $data3  = new HardwareDamageApply();

            $data3->comp_id = $comp_id;
            $data3->type    = $request->applicable;
            $data3->created_by   = Auth::user()->id;
            $data3->save();
        }




        // dd($data2, $data);
        $accessories = $request->accessories;
        // $warranty    = $request->warranty;
        // $delivery    = $request->delivery;

        // For email
        ScheduleEmailCmsHardware::STORE($data2, $data, $accessories);

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


   

}

