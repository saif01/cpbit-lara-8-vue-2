<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\CMS\Email\Application\EmailSend;

class IndexController extends Controller
{
    
    // send_rem_email
    public function send_rem_email(){
        //dd( Request('id') );
        $id = Request('id');
        if( !empty($id) ){
           $success = EmailSend::SendById($id);

            if($success){
                return response()->json(['msg'=>'Email Send Successfully &#128513;', 'icon'=>'success'], 200);
            }else{
                return response()->json([
                    'msg' => 'Data not save in DB !!'
                ], 422);
            }
        }

    }
}
