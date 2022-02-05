<?php

namespace App\Http\Controllers\iVCA\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaVendorBlaclist;
use App\Models\iVca\ivcaVendorList;
use Auth;

class BlackListController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaVendorBlaclist::with('vendor')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);


        return response()->json($allData, 200);

    }

    // Vendor List
    public function vendor_list(){
        $allData = ivcaVendorList::where('status', '1')
        ->where('blocked', null)
        ->select('id', 'vendor_number', 'suppier_name', 'contact_name')
        ->orderBy('vendor_number')
        ->get();
        return response()->json($allData, 200);
    }


    // vendor_list_blacklist
    public function vendor_list_blacklist(Request $request){

        //Validate
        $this->validate($request,[
            'vendor_id'     => 'required',
            'start'         => 'required',
            'end'           => 'required',
            'remarks'       => 'nullable|string|max:1000',
        ]);

        $vendor_id =  $request->vendor_id;

        
        // Store in VendorBlaclist 
        $data = new ivcaVendorBlaclist();
        $data->vendor_id    = $vendor_id;
        $data->start        = $request->start;
        $data->end          = $request->end;
        $data->remarks      = $request->remarks;
        $data->status       = null;
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();
        

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }


    }


    // vendor_list_status
    public function vendor_list_status(Request $request){

        // dd($request);

        $id       = $request->id;
        $vendorId = $request->vendorId;

        if($id && $vendorId){
            $data   = ivcaVendorBlaclist::findOrfail($id);
            $data2  = ivcaVendorList::findOrfail($vendorId);
            if($data && $data2){

                $status = $data->status;
                if($status == 1){
                    $data->status   = null;
                    $data2->blocked = null;
                }else{

                    $today = date('Y-m-d');
                    $endDate = $data->end;

                    if( $endDate <  $today ){
                        return response()->json(['status'=>'Error !', 'icon'=>'error', 'msg'=>'You trying error by Date'], 200);
                    }

                    $data->status   = 1;
                    $data2->blocked = 1;
                }

                $success    =  $data->save();
                $success2   =  $data2->save();
                return response()->json(['status'=>'Success', 'icon'=>'success', 'msg'=>'Status has been Changed'], 200);

            }
        }

        

    }
}
