<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareRemarks;
use App\Http\Controllers\Common\ImageUpload;
use Auth;

class ActionController extends Controller
{
    use ImageUpload;

    //action
    public function action($id){
        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'remarks', 'remarks.makby')  ->where('id', $id)
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

        $data = new HardwareRemarks();

        // Store in Application Complain tbl
        $data2 = HardwareComplain::find($request->comp_id);
        $data2->process      = $request->process;

        $documentPath = 'images/application/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name =  $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

        $data->comp_id      = $request->comp_id;
        $data->process      = $request->process;
        $data->details      = $request->details;
        $data->created_by   = Auth::user()->id;
       
        $success = $data->save();
        // Store in Application Complain tbl 
        $success2 = $data2->save();

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }
}

