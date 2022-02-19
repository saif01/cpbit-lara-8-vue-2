<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\Cms\Hardware\HardwareAcsosoris;
use App\Models\Cms\Hardware\HardwareSubcategory;
use App\Models\Cms\Hardware\HardwareComplain;
use App\Http\Controllers\Common\ImageUpload;
use Auth;

class HardwareController extends Controller
{
    // File Uplaod
    use ImageUpload;

    //category
    public function category(){
        $allData = HardwareCategory::with('acsosoris', 'subcat')->orderBy('name')->get();
        return response()->json($allData);
    }

    //subcategory
    // public function subcategory($id){
    //     $allData = HardwareSubcategory::where('id', $id)->select('id','name')->orderBy('name')->get();
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


        $data = new HardwareComplain();

        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

      
        $data->user_id      = Auth::user()->id;
        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->details      = $request->details;
        $data->process      = 'Not Process';
        $data->computer_name = $request->computer_name;

        //All Accessories
        if(!empty($request->accessories)){
            $data->accessories = implode(",", $request->accessories);
        }

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
