<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationComplain;
use App\Models\Cms\Application\ApplicationRemarks;
use App\Http\Controllers\Common\ImageUpload;
use Auth;
use App\Http\Controllers\CMS\Email\Application\EmailStore;


class ActionController extends Controller
{
    use ImageUpload;

    //action
    public function action($id){
        $allData = ApplicationComplain::with('makby', 'category', 'subcategory', 'remarks', 'remarks.makby', 'remarks.mail')->where('id', $id)
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

        $com_id = $request->comp_id;

        $remark_data = new ApplicationRemarks();

        // Store in Application Complain tbl
        $comp_data = ApplicationComplain::find($com_id);
        $comp_data->process      = $request->process;

        $documentPath = 'images/application/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name =  $this->documentUpload($document, $documentPath);
            $remark_data->document     = $document_full_name;
        }

        $remark_data->comp_id      = $com_id;
        $remark_data->process      = $request->process;
        $remark_data->details      = $request->details;
        $remark_data->created_by   = Auth::user()->id;
       
        $success = $remark_data->save();
        // Store in Application Complain tbl 
        $success2 = $comp_data->save();

        
        if( $request->process == 'Closed' ){
            // For email
            EmailStore::StorMailAdminAction($com_id, $remark_data->id);
        }
       

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }
}
