<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationComplain;
use Auth;

class ComplainController extends Controller
{
    //not_process
    public function not_process(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ApplicationComplain::with('makby', 'category', 'subcategory')
            ->where('process', 'Not Process')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    //processing
    public function processing(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ApplicationComplain::with('makby', 'category', 'subcategory')
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

        $allData = ApplicationComplain::with('makby', 'category', 'subcategory')
            ->where('process', 'Closed')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    


}
