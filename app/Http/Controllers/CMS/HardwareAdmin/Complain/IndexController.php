<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\CMS\Email\Hardware\EmailSend;

use Auth;
use App\Models\User;
use App\Models\SuperAdmin\ZoneOffice;

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


    // get_user_assign_zone_offices
    public function get_user_assign_zone_offices(){

        $data = User::with('zons', 'zons.zonoffice')->where('id', Auth::user()->id)->get()->pluck('zons');

        $allData = [];
        // Zone Name
        foreach($data[0] as $item){
            // $allData[] = $item['zonoffice'];
            $allData[] = [
                'name' => $item['zonoffice']['name'],
                'offices' => $item['zonoffice']['offices'],
            ];
        }

        // Custom Field Data Add
        $custom = collect( [['name' => 'All', 'offices' => 'All']] );
        $allData = $custom->merge($allData);

        //dd( $allData,  $allData[0] );
        return response()->json($allData, 200);
    }


    // get_user_zone_name
    public function get_user_zone_name(){

        $data = User::with('zons')->where('id', Auth::user()->id)->get()->pluck('zons')->toArray();
        //$data = User::with('zons')->where('id', Auth::user()->id)->get();

        $zoneName = [];
        // Zone Name
        foreach($data[0] as $item){
            $zoneName[] = $item['name'];
        }

        //dd($zoneName, $data, $data[0]);
        return response()->json($zoneName, 200);
    }


}
