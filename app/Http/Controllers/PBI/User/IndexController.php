<?php

namespace App\Http\Controllers\PBI\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $pbi = Auth::user()->pbi_roles->pluck('name');
        // // Merge collections
        //$roles = $roles->merge($pbi);
        //dd( $roles, $pbi['Farm : Poultry Farm Sales']);
        return view('pbi.user.index', compact('roles', 'pbi'));
    }
}
