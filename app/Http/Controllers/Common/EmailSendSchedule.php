<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Email\ScheduleEmail;

class EmailSendSchedule extends Controller
{
    //store 
    public static function STORE($to=null, $cc=null, $subject=null, $body=null, $document=null, $status=null){

        $data = new ScheduleEmail();

        $data->to       = $to;
        $data->cc       = $cc;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->document = $document;
        $data->status   = $status;
        $success        = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }
}
