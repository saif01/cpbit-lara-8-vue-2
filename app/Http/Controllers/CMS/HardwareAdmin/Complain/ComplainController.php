<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;


class ComplainController extends Controller
{
    //not_process
    public function not_process(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Not Process')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    //processing
    public function processing(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Processing')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 


    // closed
    public function closed(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('process', 'Closed')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    // service
    public function service(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service'])
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 



    

    // all_damaged
    public function all_damaged(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'dam_apply')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereIn('process', ['Damaged', 'Partial Damaged'])
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    // applicable_damaged
    public function applicable_damaged(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'dam_apply')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('dam_apply', function($q){
                $q->where('type', 'Applicable');
            })
            ->where('process', 'Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    //applicable_partial_damaged
    public function applicable_partial_damaged(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'dam_apply')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('dam_apply', function($q){
                $q->where('type', 'Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    // not_applicable_damaged
    public function not_applicable_damaged(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'dam_apply')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('dam_apply', function($q){
                $q->where('type', 'Not Applicable');
            })
            ->where('process', 'Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    //not_applicable_partial_damaged
    public function not_applicable_partial_damaged(){

        // Check access offices
        $accessZoneOffices = $this->zoneOfficesByAdminAccess();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'dam_apply')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('dam_apply', function($q){
                $q->where('type', 'Not Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 





    // zone Offices name By Admin Access
    public function zoneOfficesByAdminAccess(){

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
        if(sizeof($zoneOfficeName) > 1){
            foreach($zoneOfficeName as $item){
                // Array Merge
                $finalArrOffices = array_merge($finalArrOffices, $item);
            }
        }else{
            $finalArrOffices = $zoneOfficeName;
        }

        return $finalArrOffices;
        
    }


}

