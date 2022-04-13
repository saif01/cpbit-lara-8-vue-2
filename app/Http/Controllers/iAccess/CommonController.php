<?php

namespace App\Http\Controllers\iAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\iAccess\iaccessInternetRequestMail;

class CommonController extends Controller
{
    //
    public static function MailSendInternet($val){

        $data = new iaccessInternetRequestMail();



    }
}
