<?php

namespace App\Http\Controllers\iVCA\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Auth;
use DB;

use App\Models\iVca\ivcaVendorList;
use App\Models\iVca\ivcaVendorBlaclist;

use App\Models\iVCA\ivcaAuditFoodToken;
use App\Models\iVca\ivcaFoodSchedule;

use App\Models\iVCA\ivcaAuditMroToken;
use App\Models\iVca\ivcaMroSchedule;

use App\Models\iVca\ivcaTemplateMroImporter;
use App\Models\iVca\ivcaTemplateMroManufacturer;
use App\Models\iVca\ivcaTemplateMroRetailer;
use App\Models\iVca\ivcaTemplateFood;


class IndexController extends Controller
{
    

    public function index(){

        
        $roleData = Auth::user()->roles->pluck('name');
        $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // Merge collections
        $roles = $roleData->merge($ivcaData);

        //dd($roleData, $ivcaData, $roles);
        //$roles = '';

        return view('ivca.admin.index', compact('roles'));
    }


    // inactive_list
    public function inactive_list(){

        //dd('all_inactive_list');

        $ivcaVendorListInactive          = ivcaVendorList::where('status', null)->count();
        $ivcaVendorBlackListInactive     = ivcaVendorBlaclist::where('status', null)->count();
        $ivcaFoodScheduleInactive        = ivcaFoodSchedule::where('status', null)->count();
        $ivcaMroScheduleInactive         = ivcaMroSchedule::where('status', null)->count();

        // $ivcaTemplateMroImporterInactive         = ivcaTemplateMroImporter::where('status', null)->count();
        // $ivcaTemplateMroManufacturerInactive     = ivcaTemplateMroManufacturer::where('status', null)->count();
        // $ivcaTemplateMroRetailerInactive         = ivcaTemplateMroRetailer::where('status', null)->count();
        // $ivcaTemplateFoodInactive                = ivcaTemplateFood::where('status', null)->count();
       
        //dd( $ivcaVendorListInactive);

        return response()->json([
            'ivcaVendorListInactive'        => $ivcaVendorListInactive,
            'ivcaVendorBlackListInactive'   => $ivcaVendorBlackListInactive,  
            'ivcaFoodScheduleInactive'      => $ivcaFoodScheduleInactive, 
            'ivcaMroScheduleInactive'       => $ivcaMroScheduleInactive, 
        ],200);

    }


    // dashboard_data
    public function dashboard_data(){

        $allUser = User::where('status', 1)->count();

        //get all user have specific role
        $allRoleUser = User::whereHas( 'roles', function($query){
            $query->where( 'name', 'Ivca' ); // role with no admin
            }
        )->count();
    
        //Percent calculation
        $userPercent = round( ( $allRoleUser * 100 ) / $allUser ) ;


        //get all user have specific role
        $allRoleAdmin = User::whereHas( 'roles', function($query){
            $query->whereIn( 'name', ['Administrator', 'Ivca-admin' ]);
            // ->where( 'name', 'Administrator' ); // role with no admin
        })->count();
        $adminPercent = round( ( $allRoleAdmin * 100 ) / $allUser ) ;

        $vendor = ivcaVendorList::count();
        $activeVendor = ivcaVendorList::where('status', 1)->count();
        $activeVendorPercent = round( ( $activeVendor * 100 ) / $vendor );

        $blacklisVendor = ivcaVendorList::where('blocked', 1)->count();
        $blacklisVendorPercent = round( ( $blacklisVendor * 100 ) / $vendor );

        // MRO
        $auditMroToken = ivcaAuditMroToken::count();
        $mroSchedule = ivcaMroSchedule::count();
        $activeMroSchedule = ivcaMroSchedule::where('status', 1)->count();
        $activeMroSchedulePercent = round( ( $auditMroToken * 100 ) / $activeMroSchedule ) ;

        // Food
        $auditFoodToken = ivcaAuditFoodToken::count();
        $foodSchedule = ivcaFoodSchedule::count();
        $activeFoodSchedule = ivcaFoodSchedule::where('status', 1)->count();
        $activeFoodSchedulePercent = round( ( $auditFoodToken * 100 ) / $activeFoodSchedule );

       
        //dd( $ivcaVendorListInactive);

        return response()->json([
            'allUser'       => $allUser,
            'allRoleUser'   => $allRoleUser,
            'userPercent'   => $userPercent,

            'allRoleAdmin'  => $allRoleAdmin,
            'adminPercent'  => $adminPercent,
            
            'vendor'  => $vendor,
            'activeVendor'  => $activeVendor,
            'activeVendorPercent'  => $activeVendorPercent,

            'blacklisVendor'  => $blacklisVendor,
            'blacklisVendorPercent'  => $blacklisVendorPercent,

            'mroSchedule'  => $mroSchedule,
            'mroaAuditDoneSchedule'  => $auditMroToken,
            'activeMroSchedulePercent'  => $activeMroSchedulePercent,

            'foodSchedule'  => $foodSchedule,
            'foodaAuditDoneSchedule'  => $auditFoodToken,
            'activeFoodSchedulePercent'  => $activeFoodSchedulePercent,
        ],200);

    }
   
}
