<?php

namespace App\Http\Controllers\iVCA\User\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaVendorList;
use App\Models\iVca\ivcaFoodSchedule;
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

        $allData = ivcaFoodSchedule::with(['vendor', 'user', 'activetoken', 'audited_food'])
                ->where('date', '>=', $today)
                ->where('status', 1)
                ->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }
}
