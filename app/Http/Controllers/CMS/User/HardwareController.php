<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\Cms\Hardware\HardwareAcsosoris;
use App\Models\Cms\Hardware\HardwareSubcategory;
use App\Models\Cms\Hardware\HardwareComplain;
use App\Http\Controllers\Common\ImageUpload;
use App\Models\Cms\Hardware\HardwareDamaged;
use Carbon\Carbon;
use Auth;

use App\Http\Controllers\CMS\Email\Hardware\EmailStore;


class HardwareController extends Controller
{
    // File Uplaod
    use ImageUpload;

    //category
    public function category(){
        $allData = HardwareCategory::with('acsosoris', 'subcat')->orderBy('name')->get();
        return response()->json($allData);
    }

   
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

        // Save for Email
        EmailStore::StorMailUserComplain($data->id);

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

       

    }


    // history
    public function history(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  HardwareComplain::with('makby', 'category', 'subcategory', 'remarks', 'remarks.makby', 'dam_apply', 'dam_apply.makby', 'ho_remarks', 'ho_remarks.makby', 'damage', 'damage.makby',  'delivery', 'delivery.makby' )
        ->where('user_id', Auth::user()->id);

        
        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('created_at', '>=', $date );
        }
        
        
        // sort_by_startDate
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery ->where('created_at', '>=', $sort_by_startDate)
                      ->where('created_at', '<=', $sort_by_endDate);
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }



    // damage_apply
    public function damage_apply(){
        $id = Request('id');

        $data = HardwareDamaged::find($id);

        if( ! $data->apply_by ){

            
            // Save new
            $data->apply_by   = Auth::user()->id;
            $data->apply_at   = date('Y-m-d H:i:s');
            $success = $data->save();

            if($success){
                return response()->json(['msg'=>'Damage replacement applied successfully. &#128513;', 'icon'=>'success'], 200);
            }else{
                return response()->json([
                    'msg' => 'Data not save in DB !!'
                ], 422);
            }

        }else{
            return response()->json(['msg'=>'Damage replacement already applied. &#128513;', 'icon'=>'warning'], 200);
        }

    }


    // complain_cancel
    public function complain_cancel(){
        //dd(Request('id'));

        $id = Request('id');

        if($id){
            $data = HardwareComplain::find($id);
            if($data){
                if($data->status == 1 && $data->process == 'Not Process'){
                    $data->status = 0;
                    $data->save();
                }
            }
        }

        return response()->json('Status Changed', 200);
    }



}
