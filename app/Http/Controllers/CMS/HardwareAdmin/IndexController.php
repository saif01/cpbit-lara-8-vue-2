<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Models\Cms\Hardware\HardwareComplain;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->hard_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return view('cms.hardware_admin.index', compact('roles'));
    }


    public function sidebar_count_data(){
        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();


        $notprocess = HardwareComplain::with('makby', 'category', 'subcategory')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Not Process')
            ->count();


        // process
        $process = HardwareComplain::with('makby', 'category', 'subcategory')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', 'Processing')
        ->count();

        // deliverable
        $deliverable = HardwareComplain::with('makby', 'category', 'subcategory')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', 'Deliverable')
        ->count();

        
        $service = HardwareComplain::with('makby', 'category', 'subcategory')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', ['Send Service', 'Back Service', 'Again Send Service'])
        ->count();

        return response()->json(['notprocess'=>$notprocess,'process'=>$process, 'deliverable'=>$deliverable, 'service'=>$service]);

    }
}
