<?php

namespace App\Http\Controllers\iTemp\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\iTemp\itempEmployee;
use App\Models\iTemp\itempEmployeeTemp;
use App\Models\iTemp\itempOthersTemp;
use Carbon\Carbon;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('itemp.admin.index', compact('roles'));
    }


    // dashboard_data
    public function dashboard_data(){

        $allEmp = itempEmployee::count();

        $todayTempRec = itempEmployeeTemp::where('created_at', Carbon::today())->count();

        $totalTempRec = itempEmployeeTemp::count();

        $totalOtherTempRec = itempOthersTemp::count();

        return response()->json(['allEmp'=> $allEmp, 'todayTempRec'=> $todayTempRec, 'totalTempRec'=> $totalTempRec, 'totalOtherTempRec'=> $totalOtherTempRec ],200);

    }
}
