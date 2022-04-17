<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareDamaged;
use Auth;

use App\Exports\h_admin\allcomplain;
use App\Exports\h_admin\alldamage;
use App\Exports\h_admin\damagereplace;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\CMS\HardwareAdmin\CommonController;

class IndexController extends Controller
{
    //index
    public function index(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  HardwareComplain::with('makby', 'category', 'subcategory')
        ->where('status', 1)
        ->where('process', '!=', 'Not Process');
        

        // Department Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at' ,[$start ." 00:00:00", $end." 23:59:59"]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                    ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // damaged
    public function damaged(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        
        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');


        $damaged_reason   = Request('damaged_reason', '');
        $applicable_type  = Request('applicable_type', '');
        $damaged_type     = Request('damaged_type', '');
        

        // Query
        $allDataQuery =  HardwareDamaged::with('makby', 'complain', 'complain.category', 'complain.subcategory', 'complain.makby');
        
        
        // start, end Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('updated_at', [$start, $end]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }

        // damaged_reason
        if( !empty($damaged_reason) && $damaged_reason != 'All' ){
            $allDataQuery->where('damaged_reason', $damaged_reason);
        }

        // applicable_type
        if( !empty($applicable_type) && $applicable_type != 'All' ){
            $allDataQuery->where('applicable_type', $applicable_type);
        }

        // damaged_type
        if( !empty($damaged_type) && $damaged_type != 'All' ){
            $allDataQuery->where('damaged_type', $damaged_type);
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                    ->paginate($paginate);

        return response()->json($allData, 200);

    }




    // damaged replace
    public function damaged_replace(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        
        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');


        $damaged_reason   = Request('damaged_reason', '');
        $applicable_type  = Request('applicable_type', '');
        $damaged_type     = Request('damaged_type', '');
        

        // Query
        $allDataQuery =  HardwareDamaged::with('makby', 'complain', 'complain.category', 'complain.subcategory', 'complain.makby', 'replace_product', 'replace_product.category')->whereNotNull('rep_pro_id');
        
        
        // start, end Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('updated_at', [$start, $end]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }

        // damaged_reason
        if( !empty($damaged_reason) && $damaged_reason != 'All' ){
            $allDataQuery->where('damaged_reason', $damaged_reason);
        }

        // applicable_type
        if( !empty($applicable_type) && $applicable_type != 'All' ){
            $allDataQuery->where('applicable_type', $applicable_type);
        }

        // damaged_type
        if( !empty($damaged_type) && $damaged_type != 'All' ){
            $allDataQuery->where('damaged_type', $damaged_type);
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                    ->paginate($paginate);

        //dd($allData);

        return response()->json($allData, 200);

    }



    // all export

    public function export_data(Request $request) 
    {
        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();
        
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  HardwareComplain::with('makby', 'category', 'subcategory')
        ->where('status', 1)
        ->where('process', '!=', 'Not Process');
        

        // Department Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at' ,[$start ." 00:00:00", $end." 23:59:59"]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        return Excel::download(new allcomplain($allData), 'complain-' . time() . '.xlsx');
    }



    // damage export

    public function export_data_damage(Request $request) 
    {
        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');



        $damaged_reason   = Request('damaged_reason', '');
        $applicable_type  = Request('applicable_type', '');
        $damaged_type     = Request('damaged_type', '');
        

        // Query
        $allDataQuery =  HardwareDamaged::with('makby', 'complain', 'complain.category', 'complain.subcategory', 'complain.makby');
        
        
        // start, end Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('updated_at', [$start, $end]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }


        // damaged_reason
        if( !empty($damaged_reason) && $damaged_reason != 'All' ){
            $allDataQuery->where('damaged_reason', $damaged_reason);
        }

        // applicable_type
        if( !empty($applicable_type) && $applicable_type != 'All' ){
            $allDataQuery->where('applicable_type', $applicable_type);
        }

        // damaged_type
        if( !empty($damaged_type) && $damaged_type != 'All' ){
            $allDataQuery->where('damaged_type', $damaged_type);
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        return Excel::download(new alldamage($allData), 'complain-' . time() . '.xlsx');
    }


    // damage replace

    public function export_data_damagereplace(Request $request) 
    {

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        
        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');


        $damaged_reason   = Request('damaged_reason', '');
        $applicable_type  = Request('applicable_type', '');
        $damaged_type     = Request('damaged_type', '');
        

        // Query
        $allDataQuery =  HardwareDamaged::with('makby', 'complain', 'complain.category', 'complain.subcategory', 'complain.makby', 'replace_product')->whereNotNull('rep_pro_id');
        
        
        // start, end Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('updated_at', [$start, $end]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }

        // damaged_reason
        if( !empty($damaged_reason) && $damaged_reason != 'All' ){
            $allDataQuery->where('damaged_reason', $damaged_reason);
        }

        // applicable_type
        if( !empty($applicable_type) && $applicable_type != 'All' ){
            $allDataQuery->where('applicable_type', $applicable_type);
        }

        // damaged_type
        if( !empty($damaged_type) && $damaged_type != 'All' ){
            $allDataQuery->where('damaged_type', $damaged_type);
        }


        // Search
        if(!empty($search_field) && $search_field != 'All'){
            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');
        }else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();
            

        //dd($allData);

        return Excel::download(new damagereplace($allData), 'complain-' . time() . '.xlsx');
    }



}
