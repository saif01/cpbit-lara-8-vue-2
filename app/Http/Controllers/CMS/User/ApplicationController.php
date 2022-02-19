<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationSubcategory;
use App\Models\Cms\Application\ApplicationCategory;
use App\Models\Cms\Application\ApplicationComplain;
use App\Http\Controllers\Common\ImageUpload;
use Auth;

class ApplicationController extends Controller
{
    use ImageUpload;

    //category
    public function category(){
        $allData = ApplicationCategory::with('subcat')->orderBy('name')->get();
        return response()->json($allData);
    }

    //subcategory
    // public function subcategory($id){
    //     $allData = ApplicationSubcategory::where('id', $id)->select('id','name')->orderBy('name')->get();
    //     return response()->json($allData);
    // }

    // complain
    public function complain(Request $request){

        // dd( $request->all() );

        //Validate
        $this->validate($request,[
            'cat_id'    => 'required',
            'subcat_id' => 'required',
            'details'   => 'required|min:10|max:20000',
        ]);


        $data = new ApplicationComplain();

        $documentPath = 'images/application/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name =  $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

        $document2     = $request->file('document2');
        // Direct any file store
        if ($document2) {
            $document_full_name2 =  $this->documentUpload($document2, $documentPath);
            $data->document2     = $document_full_name2;
        }

        $document3     = $request->file('document3');
        // Direct any file store
        if ($document3) {
            $document_full_name3 =  $this->documentUpload($document3, $documentPath);
            $data->document3     = $document_full_name3;
        }

        $document4     = $request->file('document4');
        // Direct any file store
        if ($document4) {
            $document_full_name4 =  $this->documentUpload($document4, $documentPath);
            $data->document4     = $document_full_name4;
        }

        $data->user_id      = Auth::user()->id;
        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->details      = $request->details;
        $data->process      = 'Not Process';

        $success = $data->save();

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

       

    }
}
