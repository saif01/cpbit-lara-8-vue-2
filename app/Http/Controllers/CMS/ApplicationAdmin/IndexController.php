<?php

namespace App\Http\Controllers\CMS\ApplicationAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Cms\Application\ApplicationSubcategory;
use App\Models\Cms\Application\ApplicationCategory;
use App\Models\Cms\Application\ApplicationComplain;


class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('cms.application_admin.index', compact('roles'));
    }

    // dashboard_data
    public function dashboard_data(){
        //All User
        $totalUser = User::count();
        //All Operation
        $totalCategory = ApplicationCategory::count();
        $totalSubcategory = ApplicationSubcategory::count();

        //get all user have specific role
        $totalRoleUser = User::whereHas( 'roles', function($query){
                $query->where( 'name', 'cms' ); // role with no admin
            }
        )->count();
        
        //Percent calculation
        $userPercent = round( ( $totalRoleUser * 100 ) / $totalUser );

    
        // Data group by category
        $chartData = ApplicationComplain::where('status', 1)
            ->with(['category' => function ($query) {
                $query->select('id', 'name');
            }])
            ->where('process', 'Closed')
            ->orderBy('total', 'asc')
            ->selectRaw('cat_id, count(*) as total')
            ->groupBy('cat_id')->get()->toArray();
           
        // dd( $chartData );


       

        $allData = [
            'totalUser'         => $totalUser,
            'totalRoleUser'     => $totalRoleUser,
            'userPercent'       => $userPercent,
            'totalCategory'     => $totalCategory,
            'totalSubcategory'  => $totalSubcategory,
            'chartData'         => $chartData
        ]; 


        return response()->json($allData);

        
    }


    // sidebar count
    public function sidebar_count_data(){

        $notprocess = ApplicationComplain::with('makby', 'category', 'subcategory')
            ->where('process', 'Not Process')
            ->count();

        // process
        $process = ApplicationComplain::with('makby', 'category', 'subcategory')
        ->where('process', 'Processing')
        ->count();

        return response()->json(['notprocess'=>$notprocess,'process'=>$process]);

    }


}
