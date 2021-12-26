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
use App\Http\Controllers\Login\ADLogin;

class IndexController extends Controller
{
    use Authentication;

    //login
    public function login(){

        if( Auth::check() ){
            return redirect()->route('dashboard');
        }

        return view('login.index');
    }

    // login_action
    public function login_action(Request $request){
        
        // Validations
        request()->validate([
            'login' => 'required|max:20',
            'password' => 'required|max:20',
        ]);

        $login      = $request->login;
        $password   = $request->password;


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

        //dd( config('values.app_debug'), env('APP_DEBUG') );
        if(! config('values.app_debug') ){
            // Production mode App debug false
            $response = $this->adLogin($login, $password);

        }else{
            // local mode App debug true
            $response = $this->localLogin($login);

        }

        // dd($response);


        return response()->json($response, 200);

    }


   



    // Local login
    private function localLogin($login =null){

        $allData = User::where('login', $login)->first();

        if($allData){

            if($allData->status == 1){

                //Local Server Authentication passed...
                Auth::login($allData);

                // Store Login Log status code 1 everything ok
                Log::Store($login, 1);

                $response = (object) [
                    'status'    => 'success',
                    'msg'       => 'Data found in CPB-IT',
                    'data'      => $allData,
                ];
                return $response;

            }else{

                // Store Login Log status code 2 user blocked
                Log::Store($login, 2);
                // Logout
                Auth::logout();

                $response = (object) [
                    'status'    => 'error',
                    'msg'       => 'Your ID was blocked by CPB-IT!',
                    'data'      => '',
                ];
                return $response;
            }

        }else{

            
            Auth::logout();
            // Store Login Log status code 0 means Data not found in CPB-IT
            Log::Store($login, 0);

            $response = (object) [
                'status'    => 'error',
                'msg'       => 'You are not authorized for CPB-IT',
                'data'      => $allData,
            ];
            return $response;

        }


    }


    // AD Login
    private function adLogin($login =null , $password = null){


        // Login Check By AD
        $adResponse = ADLogin::Data($login, $password);
        if($adResponse->status == 'success'){

            $response = $this->localLogin($login);

           
            // dd( $adData, $localData, $response, $adResponse);

            if( $response->status == 'success' ){

                // Local DB data
                $localData  = $response->data;
                // AD response data
                $adData     = $adResponse->data;

                // dd($adData, $localData);

                $localData->name             = $adData->UserName;
                $localData->department       = $adData->Department;
                $localData->office_id        = $adData->OfficeID;
                $localData->office_contact   = $adData->OfficeMobile;
                $localData->personal_contact = $adData->PersonalMobile;
                $localData->office_email     = $adData->OfficeEmail;
                $localData->personal_email   = $adData->PersonalEmail;
                $localData->office           = $adData->Office;
                $localData->zone_office      = str_replace('&', 'and', $adData->Office);
                $localData->business_unit    = $adData->BusinessUnit;
                $localData->nid              = $adData->NationalID;
                $localData->save();

                $response = (object) [
                    'status'    => 'success',
                    'msg'       => 'Data found in CPB-IT & Sync.',
                    'data'      => $localData,
                ];
                return $response;

            }else{

                return $response;

            }

           
        }else{
            // Store Login Log status code 3 user Not Found AD 
            Log::Store($login, 3);

            $response = (object) [
                'status'    => 'error',
                'msg'       => 'You are not authorized for AD',
                'data'      => '',
            ];
            return $response;
        }
        


    }





    // logout
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->to('login');
    }


}
