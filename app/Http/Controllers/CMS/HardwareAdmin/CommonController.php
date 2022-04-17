<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;
use App\Models\User;

class CommonController extends Controller
{
    // zone Offices name By Admin Access  
    public static function ZoneOfficesByAuth(){

        // Zones By Users access
        $zoneAccess = Auth::user()->zons()->select('name')->get()->toArray();
        $zoneAccessName = [];
        foreach( $zoneAccess as $item ){
            array_push($zoneAccessName, $item['name'] );
        }

        // Zone offices
        $zoneOffices = ZoneOffice::whereIn('name', $zoneAccessName)->get()->toArray();
        $zoneOfficeName = [];
        foreach( $zoneOffices as $item ){
            $arr = explode(",", $item['offices'] );
            array_push($zoneOfficeName, $arr);
        }

        $finalArrOffices = [];
        // Array Size
        foreach($zoneOfficeName as $item){
            // Array Merge
            $finalArrOffices = array_merge($finalArrOffices, $item);
        }
      
        return $finalArrOffices;
        
    }


    // UserZoneAccessName 
    public static function UserZoneAccessName(){

        $data = User::with('zons')->where('id', Auth::user()->id)->get()->pluck('zons')->toArray();
        //$data = User::with('zons')->where('id', Auth::user()->id)->get();

        $zoneName = [];
        // Zone Name
        foreach($data[0] as $item){
            $zoneName[] = $item['name'];
        }

        //dd($zoneName, $data, $data[0]);
        return $zoneName;
    }


    //User Role 
    public static function UserRoles(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->hard_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return $roles;
    }

    //User Role 
    public static function HOServiceUserAccess(){
       
        $userRoles = Auth::user()->hard_roles->pluck('name')->toArray();
        $Access = in_array('HO-Service', $userRoles);
        
        if($Access){
            return true;
        }else{
            return false;
        }
      
    }
}
