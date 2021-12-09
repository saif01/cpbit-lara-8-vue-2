<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = User::orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // store
    public function store(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'login'             => 'required|unique:users|max:255',
            'office_contact'    => 'nullable|min:11|max:15',
            'personal_contact'  => 'nullable|min:11|max:15',
            // 'office_contact'    => 'nullable|regex:/(01)[0-9]{9}/|max:15',
            // 'personal_contact'  => 'nullable|regex:/(01)[0-9]{9}/|max:15',
            'personal_email'    => 'required|email',
            'office_email'      => 'nullable|email',
            'office'            => 'nullable',
            'business_unit'     => 'nullable',
            'nid'               => 'nullable|regex:/[0-9]/',
        ]);

        $data = new User();

    
        $login            = strtolower($request->login);
        $name             = $request->name;
        $office_email     = $request->office_email;
        $personal_email   = $request->personal_email;

        $data = new User();

        $data->login            = $login;
        $data->name             = $name;
        $data->department       = $request->department;
        $data->office_id        = $request->office_id;
        $data->office_contact   = $request->office_contact;
        $data->personal_contact = $request->personal_contact;
        $data->office_email     = $office_email;
        $data->personal_email   = $personal_email;
        $data->office           = $request->office;
        $data->business_unit    = $request->business_unit;
        $data->nid              = $request->nid;
        $data->status           = $request->status;
        $data->admin            = $request->admin;
        $data->user             = $request->user;
        
        $data->verify           = $request->verify;
        $data->status           = $request->status;
        $data->verify_by        = Auth::user()->id;
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

        $data = User::find($id);

      
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
        $data       =  User::find($id);

        $success    =  $data->delete();

        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  User::find($id);
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