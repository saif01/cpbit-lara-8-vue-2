<?php

namespace App\Http\Controllers\Network\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Network\NetworkMainip;
use App\Models\Network\NetworkSubip;
use App\Models\Network\NetworkMainipPing;
use App\Models\Network\NetworkSubipPing;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('network.admin.index', compact('roles'));
    }

    public function dashboardData(){

        $totalMainIP = NetworkMainip::get()->count();
        $totalSubIP = NetworkSubip::get()->count();
        $totalMainPing = NetworkMainipPing::get()->count();
        $totalSubPing = NetworkSubipPing::get()->count();

        //dd($totalMainIP);

        return response()->json(['totalMainIP'=> $totalMainIP, 'totalSubIP'=> $totalSubIP, 'totalMainPing'=> $totalMainPing, 'totalSubPing'=> $totalSubPing, ]);

        //return response()->json($allData, 200);
    }
}
