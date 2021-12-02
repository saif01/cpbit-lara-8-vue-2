<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\RateLimiter;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use Cookie;
use Cache;
use App\Http\Controllers\Login\Authentication;
use App\Http\Controllers\Login\Log;

class IndexController extends Controller
{
    use Authentication;

    //login
    public function login(){

        if( Auth::check() ){
            return redirect()->route('dashboard');
        }

        return view('login.login_form');
    }

    // login_action
    public function login_action(Request $request){

        //$XSRFTOKEN =  Cookie::get('XSRF-TOKEN');

        //$attamed = $this->seCacheByName($cookie_name = $XSRFTOKEN, $data = 1, $life_time_sec = 60);
       
        // dd($attamed,  $XSRFTOKEN, $request->all(), $request);


        // Store Login Log
        Log::Store($request->login, 1);

        
        // Validations
        request()->validate([
            'login' => 'required|max:20',
            'password' => 'required|max:20',
        ]);

        // login attempts more than five times in a minute
        if( $this->suspiciousLoginCheck() ){
                $allData = [
                    'status'    =>'error',
                    'code'      => 208,
                    'msg'       =>'You are locked for 60 seconds ! Try later',
                    'attempts'  => $this->suspiciousLoginCheck()
                ];
            return response()->json($allData);
        }

      
        // dd(Cache::get(Cookie::get('XSRF-TOKEN')), $this->suspiciousLoginCheck(), $request->all(), $request);

        // Login 
        $responseDB = $this->localLogin($request);


        return response()->json($responseDB, 200);

    }


   



    // Local login
    private function localLogin($request){

        $login      = $request->login;
        $password   = $request->password;

        $allData = User::where('login', $login)->first();

        if($allData){

            if($allData->status != 1 ){
                // User Blocked
                $responseDB = [
                    'status'    => 'error',
                    'code'      => 203,
                    'msg'       => 'You are blocked ! Contact with IT',
                    'user'      => '',
                ];
            }else{
                Auth::login($allData);
                $responseDB = [
                    'status'    => 'success',
                    'code'      => 200,
                    'msg'       => 'User Data Found Successfully',
                    'user'      => $allData,
                ];
            }

            return $responseDB;

        }else{

            
            Auth::logout();

            $responseDB = [
                'status'    => 'error',
                'code'      => 204,
                'msg'       => 'User Data Not Found',
                'user'      => '',
            ];
            return $responseDB;
        }


    }


    // AD server Login
    private function adServerLogin(){

    }




    // logout
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->to('login');
    }


}
