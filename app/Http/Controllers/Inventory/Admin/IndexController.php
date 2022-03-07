<?php

namespace App\Http\Controllers\Inventory\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\User;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('inventory.admin.index', compact('roles'));
    }



   
    //category
    public function category(){
        $allData = HardwareCategory::with('acsosoris', 'subcat')->orderBy('name')->get();
        return response()->json($allData);
    }
}
