<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationComplain;
use App\Models\Cms\Application\ApplicationSubcategory;
use App\Models\Cms\Application\ApplicationCategory;
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

        $start    = Request('start', '');
        $end     = Request('end', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('status', 1)
        ->where('process', '!=', 'Not Process');
        

        // Department Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at', [$start, $end]);
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

    // canceled
    public function canceled(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start    = Request('start', '');
        $end     = Request('end', '');
        

        // Query
        $allDataQuery =  ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('status', '!=', 1);
        

        // Department Selected
        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at', [$start, $end]);
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
