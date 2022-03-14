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
use App\Models\Cms\Hardware\HardwareComplain;

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

    // STORE_DAMAGED
    public static function STORE_DAMAGED($complain, $remarks){

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
     
        
        $data->document   = $remarks->document;
        $data->created_by = $remarks->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }

    // STORE_DAMAGED_HO
    public static function STORE_DAMAGED_HO($complain, $remarks){

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

        $data->ho_id    = $remarks->id;
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->name     = $userData->name;
        $data->process  = $complain->process;
        $data->remarks  = $remarks->details;
        $data->comp_id  = $comp_id;
        $data->subject  = $subject;
     
        
        $data->document   = $remarks->document;
        $data->created_by = $remarks->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }


    //STORE_DAMAGED_REPLACE 
    public static function STORE_DAMAGED_REPLACE($complain, $remarks,  $delivery= null){

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
     
    
        $data->delivery     = 'Delivered';
        $data->rec_name     = $delivery->rec_name;
        $data->rec_contact  = $delivery->rec_contact;
        $data->rec_position = $delivery->rec_position;
            
        
        
        $data->document   = $remarks->document;
        $data->created_by = $remarks->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }

    // STORE_DELIVERY
    public static function STORE_DELIVERY($complain, $delivery_data){

        //dd($complain->id, $complain, $delivery_data);
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


        $subject = $comp_id.' : Hardware Complain Delivery Update';

        $data = new ScheduleEmailCmsHard();

        $data->delv_id  = $delivery_data->id;
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->name     = $userData->name;
        $data->process  = $complain->process;
        $data->remarks  = $delivery_data->details;
        $data->comp_id  = $comp_id;
        $data->subject  = $subject;
     
    
        $data->delivery     = 'Delivered';
        $data->rec_name     = $delivery_data->rec_name;
        $data->rec_contact  = $delivery_data->rec_contact;
        $data->rec_position = $delivery_data->rec_position;
            
        $data->document   = $delivery_data->document;
        $data->created_by = $delivery_data->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }



    // STORE_QUOTATION
    public static function STORE_QUOTATION($complain_id, $remarks,  $delivery= null){

        //dd($complain->id, $complain, $remarks);

        $complain = HardwareComplain::find($complain_id);
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


        $subject = $comp_id.' : Hardware Complain Update About Price quotation';

        $data = new ScheduleEmailCmsHard();

        $data->rem_id   = $remarks->id;
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->name     = $userData->name;
        $data->process  = $remarks->process;
        $data->remarks  = $remarks->details;
        $data->comp_id  = $comp_id;
        $data->subject  = $subject;
     
        
        $data->document   = $remarks->document;
        $data->created_by = $remarks->created_by;
        $success          = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }















   
    // Send by schedule
    public static function SEND(){

        $counter = ScheduleEmailCmsHard::whereNull('status')->count();

        if( !empty($counter) ){

            for($i=1; $i <= $counter; $i++){

                $item = ScheduleEmailCmsHard::whereNull('status')->first();

                // Send mail
                self::SendMail($item);
               
                $item->status = 1;
                $item->save();

            }

            return true;
            
        }

        return true;

    }


    // mail send
    public static function SendMail($item){

        //Send Mail
        Mail::send('mail.cms.hardware.action', compact('item'), function ($message) use ($item) {
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
                $message->attach( public_path('/images/hardware/'.$item->document) );
            }
        });

    }



    
    // Send Email
    public static function SendById($id){

        // $counter = ScheduleEmailCmsHard::whereNull('status')->count();
 
        if( !empty($id) ){

        
            $item = ScheduleEmailCmsHard::find($id);

            // Send mail
            self::SendMail($item);

            $item->status = 1;
            $item->save();

            return true;
            
        }
 
     }
 



    // public static function SEND(){

    //     $counter = ScheduleEmailCmsHard::whereNull('status')->count();

    //     if( !empty($counter) ){

    //         for($i=1; $i <= $counter; $i++){

    //             $item = ScheduleEmailCmsHard::whereNull('status')->first();

    
    //             $mailData = [
    //                 'to'         => $item->to,
    //                 'cc'         => $item->cc,
    //                 'cc'         => $item->cc,
    //                 'name'       => $item->name,
    //                 'subject'    => $item->subject,
    //                 'process'    => $item->process,
    //                 'remarks'    => $item->remarks,
    //                 'compId'     => $item->comp_id,
    //                 'tools'      => $item->accessories,
    //                 'warranty'   => $item->warranty,
    //                 'delivery'   => $item->delivery,
    //                 'document'   => $item->document,
    //             ];
    
               
    //             //Send Mail
    //             Mail::send('mail.hard-complain-action', $mailData, function ($message) use ($mailData) {
    //                 //Remove if space have
    //                 $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
    //                     $message->to($arrayTo);

    //                 if( !empty($mailData['cc']) ){
    //                     $arrayCC = array_map( 'trim', explode(',', $mailData['cc']) );
    //                     $message->cc($arrayCC);
    //                 }
    //                 $message->subject($mailData['subject']);
    //                 $message->from('it-noreply@cpbangladesh.com');
    //                 //If Attachment Have
    //                 if ( !empty($mailData['document']) ) {
    //                     $message->attach( public_path('/images/hardware/'.$mailData['document']) );
    //                 }
    //             });

    //             $item->status = 1;
    //             $item->save();

    //         }

    //         return true;
            
    //     }

    //     return true;

    // }



}
