<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Sms\SmsOperation;
use App\Models\SuperAdmin\ZoneOffice;
use App\Models\SuperAdmin\Zone;
use Auth;
use DB;

class IndexController extends Controller
{

  
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
        $allDataQuery = User::with('zons', 'hard_roles')
            ->where('delete_temp', '!=', '1')
            ->whereHas( 'roles', function($query){
                $query->whereIn( 'name', ['Hardware-admin'] ); // role with no admin
            });
        

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
            ->select('department')
            ->orderBy('department')
            ->distinct()
            ->get();

        return response()->json($allData, 200);
    }


    // zoneoffices
    public function zoneoffices(){

        $allData = ZoneOffice::where('status', 1)
            ->select('name', 'offices')
            ->orderBy('name')
            ->get();
        return response()->json($allData, 200);
    }


    // zone_data
    public function zone_data(){
        $allData = Zone::orderBy('name')->get();
        return response()->json($allData, 200);
    }


    // roles_update
    public function roles_update(Request $request){

        $id = $request->currentRoleId;

        if($id){
            $user = User::find($id);
            //Update Role in Roles table
            $success = $user->zons()->sync($request->zone);
            $success = $user->hard_roles()->sync($request->role);

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

