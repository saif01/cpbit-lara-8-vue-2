<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        if( Auth::check() ){
            return redirect()->route('dashboard');
        }

        return view('auth.index');
    }
}
