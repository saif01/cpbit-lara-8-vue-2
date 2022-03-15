<?php

namespace App\Http\Controllers\PBI\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->pbi_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return view('pbi.admin.index', compact('roles'));
    }
}
