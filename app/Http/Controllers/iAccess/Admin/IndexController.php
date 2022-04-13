<?php

namespace App\Http\Controllers\iAccess\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class IndexController extends Controller
{
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        return view('iaccess.admin.index', compact('roles'));
    }
}
