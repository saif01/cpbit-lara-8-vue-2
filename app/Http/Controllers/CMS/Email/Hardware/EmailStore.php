<?php

namespace App\Http\Controllers\CMS\Email\Hardware;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Email\ScheduleEmailCmsHardware;
use App\Models\Cms\Hardware\HardwareComplain;
use Auth;
use App\Models\User;

class EmailStore extends Controller
{
    // User Complain
    public static function StorMailUserComplain($com_id){

        $emaildata = HardwareComplain::with('category', 'subcategory')->where('id', $com_id)->first();
        
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

        $subject     = $emaildata->id.' : Hardware Complain';
        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $body = 'Dear, '. Auth::user()->name .'<hr> You have complain about '. $category .' of '. $subcategory .'.<hr>'.
                'Details: <br>' .$emaildata->details;

        $data = new ScheduleEmailCmsHardware();
        $data->to       = $to;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        $data->document = $emaildata->document;
        $data->created_by = $emaildata->user_id;
        $data->save();

        return true;
    }


    // Admin Action 
    public static function StorMailAdminAction($com_id, $rem_id, $dmj_id){
        $data = new ScheduleEmailCmsHardware();
        $emaildata = HardwareComplain::with('category', 'subcategory', 'makby', 'remarks', 'remarks.makby', 'damage')->where('id', $com_id)->first();
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
        

        $subject = $emaildata->id.' : Hardware Complain Update';

        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $user_name   = $emaildata->makby->name ?? 'N/A';
        $body = 'Dear, '. $user_name .'<hr> You have complain about <b>'. $category .'</b> of <b>'. $subcategory .'</b>.<hr> Your Product Current status is : <b>'. $emaildata->process .'</b><br><br>';

        // Start Remarks
        // Document Array
        $docArray = [];
        $body .='<hr>Remarks: <br>';
        $counter = 1;
        foreach($emaildata->remarks as $item){
            $name = $item->makby->name ?? 'N/A';
            // $body .= '('.$counter .')'. $item->details.'<br> Action By: '. $name . ', Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br>';
            $body .= '('.$counter .')'. $item->details.'<br><div style="color: #999999;text-align:center;"><i> Action By: '. $name . '<br> Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br></i></div>';
            if($item->document){
                $docArray[] = $item->document;
                // dd($docArray, $item->document);
            } 
            $counter++;
        }
        //End Remarks

        // Start Damaged
        if($emaildata->damage){
           
            // document
            if($emaildata->damage->document){
                $docArray[] = $emaildata->damage->document;
            }

            if( !empty($emaildata->damage->rep_pro_id) ){
                // Damaged Replaced Receiver 
                $body .= '<br>Damaged Replaced: <hr>Receiver Name:'. $emaildata->damage->rec_name .'<br>Receiver Contact:'. $emaildata->damage->rec_contact .'<br>Receiver Position:'. $emaildata->damage->rec_position .'<br> Action At: '. date('Y-m-d h:i A', strtotime($emaildata->damage->created_at)).'<br><br>';
            }
            
        }
        // End Damaged

        //dd($docArray, $data);
        if(!empty($docArray)){
            $data->document =  implode(",", $docArray);
        }
        //dd($docArray, $data);

       
        $data->to       = $to;
        $data->rem_id   = $rem_id;
        $data->dmj_id   = $dmj_id;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        $data->created_by = $emaildata->user_id;

        //dd($data);
        $data->save();

        return false;
    }


    // Damage Quotation Admin Action 
    public static function DamageQuotationAdminAction($com_id, $rem_id, $dmj_id){
        $data = new ScheduleEmailCmsHardware();
        $emaildata = HardwareComplain::with('category', 'subcategory', 'makby', 'remarks', 'remarks.makby', 'damage')->where('id', $com_id)->first();
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
        

        $subject = $emaildata->id.' : Hardware Complain Update';

        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $user_name   = $emaildata->makby->name ?? 'N/A';
        $body = 'Dear, '. $user_name .'<hr> You have complain about <b>'. $category .'</b> of <b>'. $subcategory .'</b>.<hr> Your Product Current status is : <b>'. $emaildata->process .'</b><br><br>';

      
        // Start Damaged
        if($emaildata->damage){
            // Damaged Quotation Send
            if( !empty($emaildata->damage->apply_quotation) ){
                $body .= '<br>Damaged Product Quotation: <hr>'. $emaildata->damage->apply_quotation .'<br><br>';
            }
            // document
            $data->document = $emaildata->damage->document;
        }
        // End Damaged
       
        $data->to       = $to;
        $data->rem_id   = $rem_id;
        $data->dmj_id   = $dmj_id;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        $data->created_by = $emaildata->user_id;

        //dd($data);
        $data->save();

        return false;
    }


    // DeliveryAdminAction
    public static function DeliveryAdminAction($com_id, $deliver_id, $dmj_id){
        $data = new ScheduleEmailCmsHardware();
        $emaildata = HardwareComplain::with('category', 'subcategory', 'makby', 'remarks', 'remarks.makby', 'delivery')->where('id', $com_id)->first();
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
        

        $subject = $emaildata->id.' : Hardware Complain Update';

        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $user_name   = $emaildata->makby->name ?? 'N/A';
        $body = 'Dear, '. $user_name .'<hr> You have complain about <b>'. $category .'</b> of <b>'. $subcategory .'</b>.<hr> Your Product Current status is : <b>'. $emaildata->process .'</b><br><br>';

        // Start Remarks
        // Document Array
        $docArray = [];
        $body .='<hr>Remarks: <br>';
        $counter = 1;
        foreach($emaildata->remarks as $item){
            $name = $item->makby->name ?? 'N/A';
            // $body .= '('.$counter .')'. $item->details.'<br> Action By: '. $name . ', Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br>';
            $body .= '<i>('.$counter .')</i>'. $item->details.'<br><div style="color: #999999;text-align:center;"><i> Action By: '. $name . '<br> Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br></i></div>';
            if($item->document){
                $docArray[] = $item->document;
                // dd($docArray, $item->document);
            } 
            $counter++;
        }
        //End Remarks

        // Start delivery
        if($emaildata->delivery){
           
            // document
            if($emaildata->delivery->document){
                $docArray[] = $emaildata->delivery->document;
            }

            if( !empty($emaildata->delivery) ){
                // delivery Replaced Receiver 
                $body .= '<br>Product delivered: <hr>Receiver Name:'. $emaildata->delivery->rec_name .'<br>Receiver Contact:'. $emaildata->delivery->rec_contact .'<br>Receiver Position:'. $emaildata->delivery->rec_position .'<br>Details:'. $emaildata->delivery->details .'<br> Action At: '. date('Y-m-d h:i A', strtotime($emaildata->delivery->created_at)).'<br><br>';
            }
            
        }
        // End delivery

        //dd($docArray, $data);
        if(!empty($docArray)){
            $data->document =  implode(",", $docArray);
        }
        //dd($docArray, $data);

       
        $data->to       = $to;
        $data->deliver_id   = $deliver_id;
        $data->cc       = $managerMail;
        $data->subject  = $subject;
        $data->body     = $body;
        $data->comp_id  = $emaildata->id;
        $data->created_by = $emaildata->user_id;

        //dd($data);
        $data->save();

        return false;
    }


    // Admin H O Action 
    public static function StorMailAdminHOAction($com_id, $ho_rem_id, $dmj_id){
        $data = new ScheduleEmailCmsHardware();
        $emaildata = HardwareComplain::with('category', 'subcategory', 'makby', 'remarks', 'remarks.makby', 'damage')->where('id', $com_id)->first();
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
        

        $subject = $emaildata->id.' : Hardware Complain Update';

        $category    = $emaildata->category->name ?? 'N/A';
        $subcategory = $emaildata->subcategory->name ?? 'N/A';
        $user_name   = $emaildata->makby->name ?? 'N/A';
        $body = 'Dear, '. $user_name .'<hr> You have complain about <b>'. $category .'</b> of <b>'. $subcategory .'</b>.<hr> Your Product Current status is : <b>'. $emaildata->process .'</b><br><br>';

        // Start Remarks
        // Document Array
        $docArray = [];
        $body .='<hr>Remarks: <br>';
        $counter = 1;
        foreach($emaildata->remarks as $item){
            $name = $item->makby->name ?? 'N/A';
            // $body .= '('.$counter .')'. $item->details.'<br> Action By: '. $name . ', Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br>';
            $body .= '<i>('.$counter .')</i>'. $item->details.'<br><div style="color: #999999;text-align:center;"><i> Action By: '. $name . '<br> Action At: '. date('d-m-Y H:i ', strtotime($item->created_at)).'<br></i></div>';
            if($item->document){
                $docArray[] = $item->document;
                // dd($docArray, $item->document);
            } 
            $counter++;
        }
        //End Remarks

        // Start Damaged
        if($emaildata->damage){
           
            // document
            if($emaildata->damage->document){
                $docArray[] = $emaildata->damage->document;
            }

            if( !empty($emaildata->damage->rep_pro_id) ){
                // Damaged Replaced Receiver 
                $body .= '<br>Damaged Replaced: <hr>Receiver Name:'. $emaildata->damage->rec_name .'<br>Receiver Contact:'. $emaildata->damage->rec_contact .'<br>Receiver Position:'. $emaildata->damage->rec_position .'<br> Action At: '. date('Y-m-d h:i A', strtotime($emaildata->damage->created_at)).'<br><br>';
            }
            
        }
        // End Damaged

        //dd($docArray, $data);
        if(!empty($docArray)){
            $data->document =  implode(",", $docArray);
        }
        //dd($docArray, $data);

       
        $data->to       = $to;
        $data->ho_rem_id   = $ho_rem_id;
        $data->dmj_id   = $dmj_id;
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
