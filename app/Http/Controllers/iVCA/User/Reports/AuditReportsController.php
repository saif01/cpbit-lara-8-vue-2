<?php

namespace App\Http\Controllers\iVCA\User\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class AuditReportsController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaSchedule::with(['vendor', 'user'])->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }


}
