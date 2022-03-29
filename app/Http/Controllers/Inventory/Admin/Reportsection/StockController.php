<?php

namespace App\Http\Controllers\Inventory\Admin\Reportsection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;

use App\Exports\inventory\newProduct;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class StockController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field           = Request('search_field', '');
        $sort_by_product        = Request('sort_by_product', '');
        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');

        $sort_by_category       = Request('sort_by_category', '');

        // $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory', 'newold')
        //     ->where('delete_temp', '!=', '1')
        //     ->where('cat_id', $sort_by_category)
        //     ->where('give_st', 1)
        //     ->whereDate('created_at', '>=', $sort_by_startDate)
        //     ->whereDate('created_at', '<=', $sort_by_endDate);
        // // Final Data
        // $allIssueData =  $allDataQuery->orderBy($sort_field, $sort_direction)
        //         ->paginate($paginate);

        //$sort_by_category = 43;

        $data = InventoryNewProduct::with('makby', 'category', 'newold')
                    ->where('delete_temp', '!=', '1')
                    ->where('give_st', 1)
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '>=', $sort_by_startDate)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->get();
                    //->groupBy('comp_id');



        // totalReceived
        $totalReceivedQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '>=', $sort_by_startDate)
                    ->whereDate('created_at', '<=', $sort_by_endDate);
        $totalReceived        = $totalReceivedQuery->count();
        $totalReceivedAmmount = $totalReceivedQuery->sum('unit_price');
        if($totalReceivedAmmount > 0) { 
            $receivedAmmountUnit  = round($totalReceivedAmmount/$totalReceived);
        }else{
            $receivedAmmountUnit = 0;
        }
        

        // totalIssue
        $totalIssueQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '>=', $sort_by_startDate)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->where('give_st', 1);    
        $totalIssue         = $totalIssueQuery->count();
        $totalIssueAmmount  = $totalIssueQuery->sum('unit_price');
        if($totalIssueAmmount > 0) { 
            $issueAmmountUnit   = round($totalIssueAmmount/$totalIssue);
        }else{
            $issueAmmountUnit = 0;
        }
        
        
        // totalDamaged
        $totalDamagedQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '>=', $sort_by_startDate)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->where('damage_st', 1);
                   
        $totalDamaged         = $totalDamagedQuery->count();
        $totalDamagedAmmount  = $totalDamagedQuery->sum('unit_price');
        if($totalDamagedAmmount > 0) { 
            $damagedAmmountUnit   = round($totalDamagedAmmount/$totalDamaged);
        }else{
            $damagedAmmountUnit = 0;
        }


        
        $totalRemainingQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->where('give_st', 0)
                    ->whereNull('damage_st');

        $totalRemaining        = $totalRemainingQuery->count();
        $totalRemainingAmmount = $totalRemainingQuery->sum('unit_price');
        if($totalRemainingAmmount > 0) { 
            $remainingAmmountUnit  = round($totalRemainingAmmount/$totalRemaining);
        }else{
            $remainingAmmountUnit = 0;
        }

              
       
        //dd($totalRemaining, $totalReceived, $totalIssue, $totalDamaged, $allIssue);

        $allData = (object) [
           'data' => $data,

           'totalReceived'          => $totalReceived,
           'totalReceivedAmmount'   => $totalReceivedAmmount,
           'receivedAmmountUnit'    => $receivedAmmountUnit,

           'totalIssue'             => $totalIssue,
           'totalIssueAmmount'      => $totalIssueAmmount,
           'issueAmmountUnit'       => $issueAmmountUnit,

           'totalDamaged'           => $totalDamaged,
           'totalDamagedAmmount'    => $totalDamagedAmmount,
           'damagedAmmountUnit'     => $damagedAmmountUnit,

           'totalRemaining'          => $totalRemaining,
           'totalRemainingAmmount'   => $totalRemainingAmmount,
           'remainingAmmountUnit'    => $remainingAmmountUnit,

        ];

        //dd($allData);

        return response()->json($allData, 200);

    }
}
