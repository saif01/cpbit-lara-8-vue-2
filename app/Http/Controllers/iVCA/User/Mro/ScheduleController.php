<?php

namespace App\Http\Controllers\iVCA\User\Mro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaVendorList;
use App\Models\iVca\ivcaMroSchedule; 
use Auth;
use App\Models\User;

class ScheduleController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $today = date('Y-m-d');

        $sd = 27;

        $allData = ivcaMroSchedule::with(['vendor', 'user', 'activetoken', 'audited_manufacturer', 'audited_importer', 'audited_retailer'])
                // ->with(['audited_manufacturer' => function($q) {
                //     $q->where('created_by', Auth::user()->id);
                // }])
                // ->with(['audited_importer' => function($q) {
                //     $q->where('created_by', Auth::user()->id);
                // }]) 
                // ->with(['audited_retailer' => function($q) {
                //     $q->where('created_by', Auth::user()->id);
                // }])    
                ->where('date', '>=', $today)
                ->where('status', 1)
                ->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }
}
