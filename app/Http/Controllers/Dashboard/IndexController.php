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

        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);

       return view('dashboard.index', compact('roles'));

        //     Auth::user()->roles->pluck('name');
        //    return view('dashboard.index');
    }


}
