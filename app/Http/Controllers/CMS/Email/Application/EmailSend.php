<?php

namespace App\Http\Controllers\CMS\Email\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Email\ScheduleEmailCmsApplication;


class EmailSend extends Controller
{
    // mail send
    public static function SendMail($item){

        //Send Mail
        Mail::send('mail.cms.application.action', compact('item'), function ($message) use ($item) {
            //Remove if space have
            $arrayTo = array_map( 'trim', explode(',', $item->to) );
                $message->to($arrayTo);

            if( !empty($item->cc) ){
                $arrayCC = array_map( 'trim', explode(',', $item->cc) );
                $message->cc($arrayCC);
            }
            $message->subject($item->subject);
            $message->from('it-noreply@cpbangladesh.com');
            //If Attachment Have
            if ( !empty($item->document) ) {
                $docArray      = explode(',', $item->document);
                foreach($docArray as $item){
                    $message->attach( public_path('/images/application/'.$item) );
                }
                
            }
        });

    }



    
    // Send Email
    public static function SendById($id){

        // $counter = ScheduleEmailCmsHard::whereNull('status')->count();
 
        if( !empty($id) ){
        
            $item = ScheduleEmailCmsApplication::find($id);

            // Send mail
            self::SendMail($item);

            $item->status = 1;
            $item->save();

            return true;
            
        }
 
    }



    // By Schedule
    public static function SendBySchedule(){

        $allData = ScheduleEmailCmsApplication::whereNull('status')->get();
        
        foreach($allData as $item){
            if( $item ){
                // Send mail
                self::SendMail($item);
    
                $item->status = 1;
                $item->save();
            }
        }
        \Log::info("Cron is working for application email send");
        return true; 
    }

}
