<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Common\Email\ScheduleEmailCmsHardware;
use Auth;
use App\Models\User;

class IndexController extends Controller
{
    // send_rem_email
    public function send_rem_email(){
        //dd( Request('id') );
        $id = Request('id');
        if( !empty($id) ){
           $success = ScheduleEmailCmsHardware::SendById($id);

            if($success){
                return response()->json(['msg'=>'Email Send Successfully &#128513;', 'icon'=>'success'], 200);
            }else{
                return response()->json([
                    'msg' => 'Data not save in DB !!'
                ], 422);
            }
        }

    }


    // get_user_zone
    public function get_user_zone(){

        $data = User::with('zons')->where('id', Auth::user()->id)->get()->pluck('zons')->toArray();
        return response()->json($data[0], 200);
    }


}
