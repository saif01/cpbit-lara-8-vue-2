<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;
use App\Http\Controllers\CMS\HardwareAdmin\CommonController;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\Inventory\InventoryOperation;


class DamagedController extends Controller
{
    // all
    public function all(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

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

    // applicable
    public function applicable(){

        // Check access offices 
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

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
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    //applicable_partial
    public function applicable_partial(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

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
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    // not_applicable
    public function not_applicable(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

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
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 

    //not_applicable_partial
    public function not_applicable_partial(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

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
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 


    // remaining_stock
    public function remaining_stock(){
        // $allData = InventoryNewProduct::with('category')
        // ->where('delete_temp', 0)
        // ->where('give_st', 0)
        // ->groupBy('cat_id')
        // ->select('*')
        // ->selectRaw('count(*) as total, cat_id')
        // ->get()
        // ->toArray();

        $allData = InventoryNewProduct::with('category')
        ->where('delete_temp', 0)
        ->where('give_st', '!=', 1)
        // ->select('*')
        // ->selectRaw('count(*) as total, cat_id')
        ->get()
        ->groupBy('cat_id')
        ->toArray();

        //dd($allData);

        return response()->json($allData,200);
    }


    // inv_operations
    public function inv_operations(){
        $allData = InventoryOperation::orderBy('name')->select('name AS text', 'id AS value') ->get();
        return response()->json($allData, 200);
    }


}
