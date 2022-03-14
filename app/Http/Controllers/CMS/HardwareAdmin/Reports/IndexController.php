<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareDamaged;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

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
            $allDataQuery->whereBetween('created_at', [$start, $end]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
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
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
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



}
