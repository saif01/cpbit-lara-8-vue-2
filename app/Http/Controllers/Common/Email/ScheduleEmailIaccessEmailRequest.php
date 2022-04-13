<?php

namespace App\Http\Controllers\Common\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Models\Email\ScheduleEmailIaccessEmailReq;
use App\Models\User;

class ScheduleEmailIaccessEmailRequest extends Controller
{
    //store 
    public static function STORE($Data, $doc){

        $userData = User::where('department',$Data->department)->where('zone_office',$Data->branch)->first();

        // manager
        $managerId      = $userData->manager_id;

        if( !empty($managerId) )
        {
            $managerId      = explode(',', $managerId);
            $managerMail    = User::whereIn( 'id', $managerId )->pluck('office_email')->toArray();

            if( !empty($managerMail) ){
                $managerMail = implode(", ", array_filter($managerMail));
                $managerMail = strtok($managerMail, ", ");
            }else{ $managerMail = null; }
        }
        elseif( !empty($userData->manager_emails) ){
            $managerMail =  strtok($userData->manager_emails, ", ");
        }
        else{ $managerMail    = null; }

        // managerName
        if( !empty($managerMail) ){
            $managerName = User::where( 'office_email', $managerMail )->orWhere('personal_email', $managerMail)->pluck('name')->first();
        }

        // bu information
        if( !empty($managerMail) ){
            $managerBusinessUnit = User::where('office_email', $managerMail )->orWhere('personal_email', $managerMail)->pluck('business_unit')->first();

            if( !empty($managerBusinessUnit) ){
                $bu_head = User::where('department', 'Business Unit Head')->where('zone_office',$Data->branch)->where('business_unit', $managerBusinessUnit)->first();
                $buName = $bu_head->name;
                
                if( !empty($bu_head->office_email) ){
                    $buMail = $bu_head->office_email ;
                }else{
                    $buMail = $bu_head->personal_email ;
                }
            }else{
                $buMail = null;
                $buName = null;
            }

            //dd($managerBusinessUnit, $managerName, $managerMail, $buMail, $buName );

        }
        
        // end bu

        $subject = $Data->name.' : Official Email Request';

        $data = new ScheduleEmailIaccessEmailReq();

        $data->to_manager     = $managerMail;
        $data->manager_name   = $managerName;

        $data->to_bu          = $buMail;
        $data->bu_name        = $buName;

        $data->to_it          = 'sagor@cpbangladesh.com';
        $data->it_name        = 'Md Saiful Alam (Sagor)';

        $data->name           = $Data->name;
        $data->email_form_id  = $Data->id;
        $data->subject        = $subject;
        $data->document       = $doc;
        $data->created_by     = $Data->created_by;
        $success              = $data->save();

        self::SEND();

        if($success){
            return true;
        }else{
            return false;
        }

    }


    // Send Email
    public static function SEND(){

        $manager_counter = ScheduleEmailIaccessEmailReq::whereNull('manager_status')->count();
        $bu_counter = ScheduleEmailIaccessEmailReq::whereNull('bu_status')->count();
        $it_counter = ScheduleEmailIaccessEmailReq::whereNull('it_status')->count();

        // current_url
        // if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        //     $url = "https://";   
        // }else{
        //     $url = "http://";
        // } 
        // $url.= $_SERVER['HTTP_HOST'];   
        // // Append the requested resource location to the URL   
        // $url.= $_SERVER['REQUEST_URI'];

        $url = 'http://cpbit-8/iaccess/form/email/email_status/' ;

        if( !empty($manager_counter) ){

            for($i=1; $i <= $manager_counter; $i++){

                $item = ScheduleEmailIaccessEmailReq::whereNull('manager_status')->first();
                
                
                $mailData = [
                    //'to'         => $item->to_manager,
                    'to'         => 'mahbubulalamrifat@gmail.com',
                    'to_name'    => $item->manager_name,
                    'name'       => $item->name,
                    'subject'    => $item->subject,
                    'document'   => $item->document,
                    'form_type'  => 'Email Request',
                    'url'        => $url.$item->id,
                ];

                //dd($mailData);
    
               
                //Send Mail
                Mail::send('mail.iaccess-email', $mailData, function ($message) use ($mailData) {
                    //Remove if space have
                    $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                        $message->to($arrayTo);

                    
                    $message->subject($mailData['subject']);
                    $message->from('it-noreply@cpbangladesh.com');
                    //If Attachment Have
                    if ( !empty($item->document) ) {
                        $message->attach( public_path('/images/iaccess/email/'.$item->document.'pdf') );
                    }
                });

                $item->manager_status = 1;
                $item->manager_datetime = Carbon::now();
                $item->save();

            }

            return true;
            
        }

        if(empty($manager_counter)){
            if( !empty($bu_counter) ){

                for($i=1; $i <= $bu_counter; $i++){

                    $item = ScheduleEmailIaccessEmailReq::whereNull('bu_status')->first();
                    
        
                    $mailData = [
                        //'to'         => $item->to_bu,
                        'to'         => 'mahbubulalamrifat@gmail.com',
                        'to_name'    => $item->bu_name,
                        'name'       => $item->name,
                        'subject'    => $item->subject,
                        'document'   => $item->document,
                        'form_type'  => 'Email Request',
                        'url'        => $url.$item->id,
                    ];
        
                
                    //Send Mail
                    Mail::send('mail.iaccess-email', $mailData, function ($message) use ($mailData) {
                        //Remove if space have
                        $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                            $message->to($arrayTo);

                        $message->subject($mailData['subject']);
                        $message->from('it-noreply@cpbangladesh.com');
                        //If Attachment Have
                        if ( !empty($item->document) ) {

                            $message->attach( public_path('images/iaccess/email/'.$item->document.'pdf') );
                        }
                    });

                    $item->bu_status = 1;
                    $item->bu_datetime = Carbon::now();
                    $item->save();

                }

                return true;
                
            }
        }

        if(empty($bu_counter)){
            if( !empty($it_counter) ){

                for($i=1; $i <= $it_counter; $i++){

                    $item = ScheduleEmailIaccessEmailReq::whereNull('it_status')->first();
                    
        
                    $mailData = [
                        //'to'         => $item->to_it,
                        'to'         => 'mahbubulalamrifat@gmail.com',
                        'to_name'    => $item->it_name,
                        'name'       => $item->name,
                        'subject'    => $item->subject,
                        'document'   => $item->document,
                        'form_type'  => 'Email Request',
                        'url'        => $url.$item->id,
                    ];
        
                
                    //Send Mail
                    Mail::send('mail.iaccess-email', $mailData, function ($message) use ($mailData) {
                        //Remove if space have
                        $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                            $message->to($arrayTo);

                        $message->subject($mailData['subject']);
                        $message->from('it-noreply@cpbangladesh.com');
                        //If Attachment Have
                        if ( !empty($item->document) ) {

                            $message->attach( public_path('images/iaccess/email/'.$item->document.'pdf') );
                        }
                    });

                    $item->it_status = 1;
                    $item->it_datetime = Carbon::now();
                    $item->save();

                }

                return true;
                
            }
        }

        return true;

    }

}
