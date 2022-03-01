<?php

namespace App\Http\Controllers\Common\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Models\Email\ScheduleEmailCmsHard;
use App\Models\User;

class ScheduleEmailCmsHardware extends Controller
{
    //store 
    public static function STORE($complain, $remarks, $accessories = null, $warranty= null, $delivery= null){

        //dd($complain->id, $complain, $remarks);
        $comp_id = $complain->id;


        //user Data
        $userData = User::findOrFail($complain->user_id);

        $personal_email = $userData->personal_email;
        $office_email   = $userData->office_email;

        if( !empty($office_email) ){
            $to = $office_email;
        }else{
            $to = $personal_email;
        }

        $managerId      = $userData->manager_id;
        if( !empty($managerId) )
        {
            $managerId      = explode(',', $managerId);
            $managerMail    = User::whereIn( 'id', $managerId )->pluck('office_email')->toArray();
            if( !empty($managerMail) ){
                $managerMail    = implode(", ", array_filter($managerMail));
            }else{ $managerMail = null; }
        }
        elseif( !empty($userData->manager_emails) ){
            $managerMail =  $userData->manager_emails;
        }
        else{ $managerMail    = null; }


        $subject = $comp_id.' : Hardware Complain Update';

        $data = new ScheduleEmailCmsHard();

        $data->rem_id   = $remarks->id;
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->name     = $userData->name;
        $data->process  = $complain->process;
        $data->remarks  = $remarks->details;
        $data->comp_id  = $comp_id;
        $data->subject  = $subject;
        //All Accessories
        if(!empty($accessories)){
            $data->accessories = implode(",", $accessories);
        }
        if(!empty($warranty)){
            $data->warranty = $warranty;
        }
        if(!empty($delivery)){
            $data->delivery = $delivery;
        }
        
        $data->document   = $remarks->document;
        $data->created_by = $remarks->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }


    // Send Email
    public static function SendById($id){

       // $counter = ScheduleEmailCmsHard::whereNull('status')->count();

        if( !empty($id) ){

        

                $item = ScheduleEmailCmsHard::find($id);

                $mailData = [
                    'to'         => $item->to,
                    'cc'         => $item->cc,
                    'cc'         => $item->cc,
                    'name'       => $item->name,
                    'subject'    => $item->subject,
                    'process'    => $item->process,
                    'remarks'    => $item->remarks,
                    'compId'     => $item->comp_id,
                    'tools'      => $item->accessories,
                    'warranty'   => $item->warranty,
                    'delivery'   => $item->delivery,
                    'document'   => $item->document,
                ];
    
               
                //Send Mail
                Mail::send('mail.hard-complain-action', $mailData, function ($message) use ($mailData) {
                    //Remove if space have
                    $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                        $message->to($arrayTo);

                    if( !empty($mailData['cc']) ){
                        $arrayCC = array_map( 'trim', explode(',', $mailData['cc']) );
                        $message->cc($arrayCC);
                    }
                    $message->subject($mailData['subject']);
                    $message->from('it-noreply@cpbangladesh.com');
                    //If Attachment Have
                    if ( !empty($mailData['document']) ) {
                        $message->attach( public_path('/images/hardware/'.$mailData['document']) );
                    }
                });

                $item->status = 1;
                $item->save();

            return true;
            
        }

    }

    public static function SEND(){

        $counter = ScheduleEmailCmsHard::whereNull('status')->count();

        if( !empty($counter) ){

            for($i=1; $i <= $counter; $i++){

                $item = ScheduleEmailCmsHard::whereNull('status')->first();

    
                $mailData = [
                    'to'         => $item->to,
                    'cc'         => $item->cc,
                    'cc'         => $item->cc,
                    'name'       => $item->name,
                    'subject'    => $item->subject,
                    'process'    => $item->process,
                    'remarks'    => $item->remarks,
                    'compId'     => $item->comp_id,
                    'tools'      => $item->accessories,
                    'warranty'   => $item->warranty,
                    'delivery'   => $item->delivery,
                    'document'   => $item->document,
                ];
    
               
                //Send Mail
                Mail::send('mail.hard-complain-action', $mailData, function ($message) use ($mailData) {
                    //Remove if space have
                    $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                        $message->to($arrayTo);

                    if( !empty($mailData['cc']) ){
                        $arrayCC = array_map( 'trim', explode(',', $mailData['cc']) );
                        $message->cc($arrayCC);
                    }
                    $message->subject($mailData['subject']);
                    $message->from('it-noreply@cpbangladesh.com');
                    //If Attachment Have
                    if ( !empty($mailData['document']) ) {
                        $message->attach( public_path('/images/hardware/'.$mailData['document']) );
                    }
                });

                $item->status = 1;
                $item->save();

            }

            return true;
            
        }

        return true;

    }
}
