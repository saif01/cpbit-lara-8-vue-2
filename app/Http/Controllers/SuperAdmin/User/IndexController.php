<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Auth;
use App\Http\Controllers\Common\ImageUpload;

class IndexController extends Controller
{
    use ImageUpload;

    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        if(!empty($search_field)){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allData = User::with('roles')
            ->where('delete_temp', '!=', '1')
            ->where($search_field, 'LIKE', '%'.$val.'%')
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        }else{

            $allData = User::with('roles')
            ->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        }

        

        return response()->json($allData, 200);

    }

    // roles_data
    public function roles_data(){
        $allData = Role::orderBy('name')->get();
        return response()->json($allData, 200);
    }


    // roles_update
    public function roles_update(Request $request ){

        $id = $request->currentRoleId;

        if($id){
            $user = User::find($id);
            //Update Role in Roles table
            $success = $user->roles()->sync($request->roles);

            if($success){
                return response()->json(['msg'=>'Update Successfully &#128513;', 'icon'=>'success'], 200);
            }else{
                return response()->json([
                    'msg' => 'Data not save in DB !!'
                ], 422);
            }

        }else{
            return response()->json([
                'msg' => 'User id not found!!'
            ], 422);
        }

        
    }


    // store
    public function store(Request $request){

       
        //dd($request->all());

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

    
        $login            = strtolower($request->login);
        $name             = $request->name;
        $office_email     = $request->office_email;
        $personal_email   = $request->personal_email;

        $data = new User();

        $data->login            = $login;
        $data->user             = $request->user;
        $data->admin            = $request->admin;
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

        if(!empty($request->manager_id)){
            $data->manager_id       = implode(",", $request->manager_id);
            $data->manager_emails   = null;
        }

        if(!empty($request->manager_emails)){
            $data->manager_emails   = $request->manager_emails;
            $data->manager_id       = null;
        }
        
    
        $data->status           = $request->status;
        $data->status_by        = Auth::user()->id;
        $data->verify           = 1;
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

        
      // dd($request->all());

        //Validate
        $this->validate($request,[
            'login'             => 'required|min:3|max:20|unique:users,login,'.$id,
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

      

    
        $login            = strtolower($request->login);
        $name             = $request->name;
        $office_email     = $request->office_email;
        $personal_email   = $request->personal_email;

        $data = User::find($id);
      
        $data->login            = $login;
        $data->user             = $request->user;
        $data->admin            = $request->admin;
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

        if( $data->manager_id != $request->manager_id  && !empty($request->manager_id) ){
            $data->manager_id       = implode(",", $request->manager_id);
            $data->manager_emails   = null;
        }

        if( $data->manager_emails != $request->manager_emails && !empty($request->manager_emails) ){
            $data->manager_emails   = $request->manager_emails;
            $data->manager_id       = null;
        }


        $imagePath      = 'images/users/';
        $current_image  = $request->image; 
        $old_image      = $data->image;
        // Save Image a
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }
        
    
        
        $data->status           = $request->status;
        $data->status_by        = Auth::user()->id;
        $data->verify           = 1;
        $data->verify_by        = Auth::user()->id;
        $success                = $data->save();

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
                $data->status = 0;
                $data->status_by = Auth::user()->id;

            }else{
                $data->status = 1;
                $data->status_by = Auth::user()->id;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }


    // status_admin
    public function status_admin($id){

        $data       =  User::find($id);
        if($data){

           $admin = $data->admin;
           
            if($admin == 1){
                $data->admin = 0;
            }else{
                $data->admin = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }

    // status_user
    public function status_user($id){

        $data       =  User::find($id);
        if($data){

           $user = $data->user;
           
            if($user == 1){
                $data->user = 0;
            }else{
                $data->user = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }


}