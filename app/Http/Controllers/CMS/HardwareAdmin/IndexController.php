<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->hard_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return view('cms.hardware_admin.index', compact('roles'));
    }
}
