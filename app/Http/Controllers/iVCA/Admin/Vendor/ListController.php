<?php

namespace App\Http\Controllers\iVCA\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaVendorList;
use Auth;

class ListController extends Controller
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

        $allData = ivcaVendorList::orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'vendor_number'     => 'required|max:100|unique:ivca_vendor_lists',
            'suppier_name'      => 'nullable|string|max:100',
            'address'           => 'nullable|string|max:1000',
            'contact_name'      => 'nullable|string|max:100',
            'email'             => 'nullable|email|max:100',
            'telephone'         => 'nullable|string|max:100',
        ]);

        $data = new ivcaVendorList();

    
        $data->vendor_number= $request->vendor_number;
        $data->suppier_name = $request->suppier_name;
        $data->address      = $request->address;
        $data->contact_name = $request->contact_name;
        $data->email        = $request->email;
        $data->telephone    = $request->telephone;
        $data->status       = null;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

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
            'vendor_number'     => 'required|max:1000|unique:ivca_vendor_lists,vendor_number,'.$id,
            'suppier_name'      => 'nullable|string|max:100',
            'address'           => 'nullable|string|max:1000',
            'contact_name'      => 'nullable|string|max:100',
            'email'             => 'nullable|email|max:100',
            'telephone'         => 'nullable|string|max:100',
        ]);

        $data = ivcaVendorList::find($id);

      
        $data->vendor_number= $request->vendor_number;
        $data->suppier_name = $request->suppier_name;
        $data->address      = $request->address;
        $data->contact_name = $request->contact_name;
        $data->email        = $request->email;
        $data->telephone    = $request->telephone;
        $data->status       = null;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // destroy
    public function destroy($id)
    {
        $data       =  ivcaVendorList::find($id);

        $success    =  $data->delete();

        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  ivcaVendorList::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
                $data->status_by = Auth::user()->id;

            }else{
                $data->status = 1;
                $data->status_by = Auth::user()->id;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }



}

