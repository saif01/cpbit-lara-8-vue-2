<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Auth;
use DB;

class IndexController extends Controller
{
    //index
    public function index(){

        // $roleData = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);

       // return view('dashboard.index', compact('roles'));

        return view('dashboard.index');
    }


    //user 
    public function user(){

        if( Auth::user()->user == 1 ){
            return view('dashboard.user');
        } 
       
    }

    // admin
    public function admin(){
        if( Auth::user()->admin == 1 ){
            return view('dashboard.admin');
        } 
    }
}
