<?php

namespace App\Http\Controllers\SuperAdmin\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Role;
use Auth;
use App\Http\Controllers\Common\ImageUpload;
use App\Models\UserReginster;

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

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // $allData = UserReginster::with('verified')->orderBy($sort_field, $sort_direction)
        //     ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
        //     ->paginate($paginate);

        // Query
        $allDataQuery = UserReginster::with('verified');
        
        // Zone Selected
        if(!empty($zone_office)){
            $allDataQuery->whereIn('office', explode(",",$zone_office));
        }

        // Department Selected
        if(!empty($department)){
            $allDataQuery->whereIn('department', explode(",",$department));
        }

        // Search
        if(!empty($search_field)){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);

       
        return response()->json($allData, 200);

    }

   


    // store
    public function store(Request $request){

       
        //dd($request->roles,  $request->all());

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
            //'nid'               => 'nullable|regex:/[0-9]/',
        ]);

    
        $login            = strtolower($request->login);
        $name             = $request->name;
        $office_email     = $request->office_email;
        $personal_email   = $request->personal_email;

        $data = new User();

        $registerData = UserReginster::where('login', $login)->first();

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

        // $imagePath      = 'images/users/';
        // $current_image  = $request->image; 
        // // Save Image a
        // if(!empty($current_image)){
        //     $imgName= $this->imageUplaodByName($current_image, null, $imagePath); 
        //     $data->image = $imgName;
        // }

        $imagePath      = 'images/users/';
        $current_image  = $request->image; 
        $old_image      = $registerData->image ?? null;
        // Save Image a
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }else{
            $data->image = $old_image; 
        }

        
        $data->status           = $request->status;
        $data->status_by        = Auth::user()->id;
        $data->verify           = 1;
        $data->verify_by        = Auth::user()->id;
        $success                = $data->save();

        // Assign Roles
        $currentRoles =   $request->roles;
        if(!empty($currentRoles)){
            $data->roles()->sync($currentRoles);
        }

        // Update RegisterUser Table
        $registerData->status           = $request->status;
        $registerData->status_by        = Auth::user()->id;
        $registerData->verify           = 1;
        $registerData->verify_by        = Auth::user()->id;
        $success2                       = $registerData->save();


       

        


        //dd($data, $registerData);

        if($success && $success2){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


  





}
