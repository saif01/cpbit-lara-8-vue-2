<?php

namespace App\Http\Controllers\CMS\Email\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Email\ScheduleEmailCmsApplication;
use App\Models\Cms\Application\ApplicationComplain;
use Auth;
use App\Models\User;

class EmailStore extends Controller
{
    // User Complain
    public static function StorMailUserComplain($com_id){

        $emaildata = ApplicationComplain::with('category', 'subcategory')->where('id', $com_id)->first();
        
        if( !empty(Auth::user()->office_email) ){
            $to = Auth::user()->office_email;
        }else{
            $to = Auth::user()->personal_email;
        }

        $managerId      = Auth::user()->manager_id;
        if( !empty($managerId) )
        {
            $managerId      = explode(',', $managerId);
            $managerMail    = User::whereIn( 'id', $managerId )->pluck('office_email')->toArray();
            if( !empty($managerMail) ){
                $managerMail    = implode(", ", array_filter($managerMail));
            }else{ $managerMail = null; }
        }
        elseif( !empty(Auth::user()->manager_emails) ){
            $managerMail =  Auth::user()->manager_emails;
        }
        else{ $managerMail    = null; }

        $subject     = $emaildata->id.' : Application Complain';
        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $body = 'Dear, '. Auth::user()->name .'<hr> You have complain about '. $category .' of '. $subcategory .'.<hr>'.
                'Details: <br>' .$emaildata->details;

        $data = new ScheduleEmailCmsApplication();
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        
        $docArray = [];
        if($emaildata->document){
            $docArray[] = $emaildata->document;
        }
        if($emaildata->document2){
            $docArray[] = $emaildata->document2;
        }
        if($emaildata->document3){
            $docArray[] = $emaildata->document3;
        }
        if($emaildata->document4){
            $docArray[] = $emaildata->document4;
        }

        if(!empty($docArray)){
            $data->document =  implode(",", $docArray);
        }

        $data->created_by = $emaildata->user_id;
        $data->save();

        return true;
    }

    // Admin Action 
    public static function StorMailAdminAction($com_id, $rem_id){
        $data = new ScheduleEmailCmsApplication();
        $emaildata = ApplicationComplain::with('category', 'subcategory', 'makby', 'remarks', 'remarks.makby')->where('id', $com_id)->first();
        if(empty($emaildata->makby)){
            // user not found return back
            return true;
        }

        if( !empty($emaildata->makby->office_email) ){
            $to = $emaildata->makby->office_email;
        }else{
            $to = $emaildata->makby->personal_email;
        }

        $managerId      = $emaildata->makby->manager_id;
        if( !empty($managerId) )
        {
            $managerId      = explode(',', $managerId);
            $managerMail    = User::whereIn( 'id', $managerId )->pluck('office_email')->toArray();
            if( !empty($managerMail) ){
                $managerMail    = implode(", ", array_filter($managerMail));
            }else{ $managerMail = null; }
        }
        elseif( !empty($emaildata->makby->manager_emails) ){
            $managerMail =  $emaildata->makby->manager_emails;
        }
        else{ $managerMail    = null; }
        

        $subject = $emaildata->id.' : Application Complain Update';

        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $user_name   = $emaildata->makby->name ?? 'N/A';
        $body = 'Dear, '. $user_name .'<hr> You have complain about <b>'. $subcategory .'</b> of <b>'. $category .'</b>.<hr> Your Complain Current status is : <b>'. $emaildata->process .'</b><br><br>';

        // Start Remarks
        // Document Array
        $docArray = [];
        $body .='<hr>Remarks: <br>';
        $counter = 1;
        foreach($emaildata->remarks as $item){
            $name = $item->makby->name ?? 'N/A';
            $body .= '<i>('.$counter .')</i>'. $item->details.'<br><div style="color: #999999;text-align:center;"><i> Action By: '. $name . '<br> Action At: '. date('d-m-Y h:i A ', strtotime($item->created_at)).'<br></i></div>';
            if($item->document){
                $docArray[] = $item->document;
                // dd($docArray, $item->document);
            } 
            $counter++;
        }
        //End Remarks


        //dd($docArray, $data);
        if(!empty($docArray)){
            $data->document =  implode(",", $docArray);
        }
        //dd($docArray, $data);

       
        $data->to       = $to;
        $data->rem_id   = $rem_id;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        $data->created_by = $emaildata->user_id;

        //dd($data);
        $data->save();

        return false;
    }


}
