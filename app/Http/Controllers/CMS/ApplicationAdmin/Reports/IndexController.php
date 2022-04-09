<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationComplain;
use App\Models\Cms\Application\ApplicationSubcategory;
use App\Models\Cms\Application\ApplicationCategory;
use Auth;

use App\Exports\h_application\allcomplain;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start    = Request('start', '');
        $end     = Request('end', '');

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
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
        if( !empty($department) ){
            $allDataQuery->whereHas('makby', function($q) use($department){
                $q->where('department', $department);
            });
        }

        // Search

        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'makby', function($query) use($val){
                $query->where('department', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                    ->paginate($paginate);

        return response()->json($allData);

    }

    // canceled
    public function canceled(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start    = Request('start', '');
        $end     = Request('end', '');

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('status', '!=', 1);
        

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
        if( !empty($department) ){
            $allDataQuery->whereHas('makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }

        
        // search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'makby', function($query) use($val){
                $query->where('department', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }

            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                    ->paginate($paginate);

        return response()->json($allData, 200);

    }



    public function export_data(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start    = Request('start', '');
        $end     = Request('end', '');

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('status', 1)
        ->where('process', '!=', 'Not Process');
        

        // date Selected
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
        if( !empty($department) ){
            $allDataQuery->whereHas('makby', function($q) use($department){
                $q->where('department', $department);
            });
        }

        // Search

        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'makby', function($query) use($val){
                $query->where('department', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        // return response()->json($allData, 200);

        //return (new allcomplain($allData))->download('complain.xlsx');

        return Excel::download(new allcomplain($allData), 'complain-' . time() . '.xlsx');
    }


    public function export_data_cancel(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start    = Request('start', '');
        $end     = Request('end', '');

        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('status', '!=', 1);
        

        // date Selected
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
        if( !empty($department) ){
            $allDataQuery->whereHas('makby', function($q) use($department){
                $q->where('department', $department);
            });
        }

        // Search

        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'department'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'makby', function($query) use($val){
                $query->where('department', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }
            
        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        // return response()->json($allData, 200);

        //return (new allcomplain($allData))->download('complain.xlsx');

        return Excel::download(new allcomplain($allData), 'complain-' . time() . '.xlsx');
    }



}
