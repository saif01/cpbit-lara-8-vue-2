<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;


class IndexController extends Controller
{
    //login
    public function login(){

        if( Auth::check() ){
            return redirect()->route('dashboard');
        }

        return view('login.login_form');
    }

    // login_action
    public function login_action(Request $request){

        //dd($request->all());

        $response = $this->localLogin($request);

        if($response == 'error' ){
            return response()->json($response, 204);
        }

        return response()->json($response, 200);

    }



    // Local login
    private function localLogin($request){

        $login      = $request->login;
        $password   = $request->password;

        $allData = User::where('login', $login)->first();

        if($allData){
            Auth::login($allData);

            return $allData;

        }else{

            Session::flush();
            Auth::logout();

            return 'error';
        }


    }




    // logout
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->to('login');
    }


}
