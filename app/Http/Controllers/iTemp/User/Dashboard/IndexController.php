<?php

namespace App\Http\Controllers\iTemp\User\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\iTemp\itempEmployee;
use DB;

class IndexController extends Controller
{
    public function dashboard_graph(){
        $allData = itempEmployee::select('department',  DB::raw('count(*) as total'))
            ->groupBy('department')
            ->get();

        return response()->json($allData, 200);
    }
}
