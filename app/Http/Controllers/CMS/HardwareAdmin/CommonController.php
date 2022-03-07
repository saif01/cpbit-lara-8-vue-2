<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;

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
}
