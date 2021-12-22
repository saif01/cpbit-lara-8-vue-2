<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        return view('welcome');
    }
}
