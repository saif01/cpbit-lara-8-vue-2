<?php

namespace App\Http\Controllers\iVCA\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Auth;
use DB;

class IndexController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function Index(){

        $roleData = Auth::user()->roles->pluck('name');
        $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // Merge collections
        $roles = $roleData->merge($ivcaData);

        //$roles = '';

        return view('ivca.user.index', compact('roles'));
    }
}
