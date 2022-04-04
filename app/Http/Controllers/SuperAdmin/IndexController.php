<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\SuperAdmin\Zone;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('super_admin.index', compact('roles'));
    }


    // dashboard_data
    public function dashboard_data(){

        //$user = User::where('delete_temp', 0)->get();

        $admin = User::where('delete_temp', 0)->where('admin', 1)->count();
        $user = User::where('delete_temp', 0)->where('user', 1)->count();
        $adminUser = User::where('delete_temp', 0)->where('admin', 1)->where('user', 1)->count();
        $blockedUser = User::where('delete_temp', 0)->where('status', 0)->count();
        $totalUser = User::where('delete_temp', 0)->count();

        $totalRole = Role::where('status', 1)->count();
        $totalZone = Zone::where('status', 1)->count();

        $allData = (object) [

            'admin' => $admin,
            'user' => $user,
            'adminUser' => $adminUser,
            'blockedUser' => $blockedUser,
            'totalUser' => $totalUser,

            'totalRole' => $totalRole,
            'totalZone' => $totalZone,

        ];

        // dd($allData);
        return response()->json($allData, 200);

    }


}
