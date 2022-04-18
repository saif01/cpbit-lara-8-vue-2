<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareDamaged;

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
        $deliverable = HardwareComplain::with('makby')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', 'Deliverable')
        ->count();

        
        $service = HardwareComplain::with('makby')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', ['Send Service', 'Back Service', 'Again Send Service'])
        ->count();

        $serviceAccess = HardwareComplain::with('makby')
        ->where('process', ['Send Service', 'Back Service', 'Again Send Service'])
        ->count();

        // HO Service 
        $hoServiceAccess = HardwareComplain::with('makby')
        ->where('process', 'HO Service')
        ->count();

        $hoService = HardwareComplain::with('makby')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', 'HO Service')
        ->count();

        return response()->json(['notprocess'=>$notprocess,'process'=>$process, 'deliverable'=>$deliverable, 'service'=>$service , 'serviceAccess'=>$serviceAccess, 'hoService'=>$hoService, 'hoServiceAccess'=>$hoServiceAccess]);

    }



    // dashboard_data
    public function dashboard_data(){

        $allComplain = HardwareComplain::count();
        $allProcessingComplain = HardwareComplain::where('process', 'Processing')->count();
        $allClosedComplain = HardwareComplain::where('process', 'Closed')->count();

        $productWiseComplain = HardwareComplain::with('category')
            ->groupBy('cat_id')
            ->selectRaw('count(*) as total, cat_id')
            ->get()
            ->toArray();


        $damageWiseComplain = HardwareDamaged::with('complain', 'complain.category')
            ->groupBy('damaged_type')
            ->whereNotNull('damaged_type')
            ->selectRaw('count(*) as total, damaged_type')
            ->get()
            ->toArray();


         $alldata = ['productWiseComplain'=>$productWiseComplain,
            'allComplain'           => $allComplain, 
            'damageWiseComplain'    => $damageWiseComplain,
            'allProcessingComplain' => $allProcessingComplain,
            'allClosedComplain'     => $allClosedComplain,

            ];

        return response()->json($alldata, 200);
    }
}
