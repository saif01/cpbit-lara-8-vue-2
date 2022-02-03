<?php

namespace App\Http\Controllers\Sms\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Sms\SmsOperation;
use App\Models\User;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('sms.admin.index', compact('roles'));
    }



    // dashboard_data
    public function dashboard_data(){
        //All User
        $allUser = User::count();
        //All Operation
        $allOperation = SmsOperation::count();

        //get all user have specific role
        $allRoleUser = User::whereHas( 'roles', function($query){
                $query->where( 'name', 'Sms' ); // role with no admin
            }
        )->count();
        
        //Percent calculation
        $userPercent = round( ( $allRoleUser * 100 ) / $allUser ) ;


        //get all user have specific role
        $allRoleAdmin = User::whereHas( 'roles', function($query){
                $query->whereIn( 'name', ['Administrator', 'Sms-admin' ]);
                    // ->where( 'name', 'Administrator' ); // role with no admin
            }
        )->count();
        
        $adminPercent = round( ( $allRoleAdmin * 100 ) / $allUser );

        $allData = [
            'allUser' => $allUser,
            'allRoleUser' => $allRoleUser,
            'userPercent' => $userPercent,
            'allOperation' => $allOperation,
            'allRoleAdmin' => $allRoleAdmin,
            'adminPercent' => $adminPercent,
        ]; 


        return response()->json($allData);

        
    }
}
