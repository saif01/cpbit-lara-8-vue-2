<?php

namespace App\Http\Controllers\Auth\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Login\DeviceInfo;
use App\Models\UserLoginLog;

class Log extends Controller
{

    // Store
    public static function Store( $login_id='', $status='' ){

        $info = DeviceInfo::user_ip_details();
        // dd($info, $info->country, $info->city, $info->lat, $info->lon, $info->isp );
        
        $data = new UserLoginLog();

        $data->login_id     =  $login_id;
        $data->status       =  $status;
        $data->ip           =  DeviceInfo::get_ip();
        $data->os           =  DeviceInfo::get_os();
        $data->browser      =  DeviceInfo::get_browser();
        $data->device       =  DeviceInfo::get_device();

        $data->city         =  $info->city;
        $data->region       =  $info->region;
        $data->country      =  $info->country;
        $data->lat          =  $info->lat;
        $data->lon          =  $info->lon;
        $data->isp          =  $info->isp;
        $data->save();
       
    }

    //test
    public function test(  ){

        $info = DeviceInfo::user_ip_details();
        dd($info, $info->country, $info->city, $info->lat, $info->lon, $info->isp );
    }
}
