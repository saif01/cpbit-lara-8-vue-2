<?php

namespace App\Http\Controllers\MobileApp\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MobileApp\MobileAppRole;
use App\Models\User;
use Auth;
use DB;

class IndexController extends Controller
{

    public function apiAsset2(Request $request){

        $id = $request->id ?? null;
        $module = $request->module ?? null;
       
        dd( $id, $module,  $request->all() );
    }

    // apiAsset
    public function apiAsset(Request $request){

        $id = $request->id ?? null;
        $module = $request->module ?? null;
        
       // dd( $id, $module,  $request->all() );

        // Check Data Table exist
        $tblNotFound  = DB::getSchemaBuilder()->hasTable('users');
        $tblNotFound2 = DB::getSchemaBuilder()->hasTable('mobile_app_roles');
        $tblNotFound3 = DB::getSchemaBuilder()->hasTable('mobile_app_role_user');
        //dd($tblNotFound); 
        if(!$tblNotFound || !$tblNotFound2 || !$tblNotFound3){
            $allData = [
                'status'  =>  'error',
                'code'    =>  404,
                'data'    =>  '',
                'message' => 'Data Table not found',
            ];
            return response()->json($allData, 200); 
        }

        if( empty($id) || empty($module) ){
            $allData = [
                'status'  =>  'error',
                'code'    =>  404,
                'data'    =>  '',
                'message' => 'Data parameter error',
            ];
            return response()->json($allData, 200); 
        }

        // Check User
        $userData = User::where('login', $id)->first();
        if( $userData ){
            // User Role
            $result = $userData->mobile_app_hasRole($module);
            $allData =[
                'status'    =>  'Success',
                'code'      =>  200,
                'data'      =>  $result,
                'message'   =>  'Successfully data found',
            ];

           // dd($allData);
           
        }else{
            $allData =[
                'status'    =>  'error',
                'code'      =>  404,
                'data'      =>  '',
                'message'   =>  'User data not found',
            ];
        }
    
        return response()->json($allData, 200);
    }
    
    //index
    public function index(){


        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery = User::with('mobile_app_roles')
            ->where('delete_temp', '!=', '1')
            ->where('status', '1');
            // ->whereHas( 'roles', function($query){
            //     $query->whereIn( 'name', ['Powerbi', 'Powerbi-admin'] ); // role with no admin
            // });
        

        // Zone Selected
        if(!empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereIn('zone_office', explode(",",$zone_office));
        }

        // Department Selected
        if(!empty($department) && $department != 'All'){
            $allDataQuery->whereIn('department', explode(",",$department));
        }

        // Search
        if(!empty($search_field) && $search_field != 'All'){
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

   
    // departments
    public function departments(){

        $allData = User::where('status', 1)
            ->select('office')
            ->orderBy('office')
            ->distinct()
            ->get();

        return response()->json($allData, 200);
    }


    // roles_data
    public function roles_data(){
        $allData = MobileAppRole::orderBy('name')->get();
        return response()->json($allData, 200);
    }


    // roles_update
    public function roles_update(Request $request){

        $id = $request->currentRoleId;

        //dd($request->all());

        if($id){
            $user = User::find($id);
            //Update Role in Roles table
            $success = $user->mobile_app_roles()->sync($request->role);

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
}
