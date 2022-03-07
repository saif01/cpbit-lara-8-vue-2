<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;
use App\Http\Controllers\CMS\HardwareAdmin\CommonController;

class HoController extends Controller
{
    //ho_service
    public function ho_service(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'zons')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'HO Service')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }  
}
