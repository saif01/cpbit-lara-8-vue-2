<?php

namespace App\Http\Controllers\Inventory\Admin\Reportsection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;

use App\Exports\inventory\stock;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class StockController extends Controller
{
    //index
    public function index(){

        $allData = $this->getData();
        return response()->json($allData, 200);

    }



    public function export_data(Request $request){

        
        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $product_name           = Request('product_name', '');

        $allDataArray =  $this->getData();
     
        $allDataArray +=  [
            'catagoryName'  => '('. date('d F, Y', strtotime($sort_by_startDate)) .' to '.date('d F, Y', strtotime($sort_by_endDate)) .') '.$product_name,
        ];

       
        $allData = (object) $allDataArray;


        //dd($allData,  $allDataArray);

        return Excel::download(new stock($allData), 'product.xlsx');
    }



    public function export_view(){

        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $product_name           = Request('product_name', '');

        $allDataArray =  $this->getData();
     
        $allDataArray +=  [
            'catagoryName'  => '('. date('d F, Y', strtotime($sort_by_startDate)) .' to '.date('d F, Y', strtotime($sort_by_endDate)) .') '.$product_name,
        ];

        $product = (object) $allDataArray;

        return view('inventory.admin.reports.stock', compact('product'));

    }




    public function getData(){

        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $sort_by_category       = Request('sort_by_category', '');

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


        // totalRemainingQuery
        $totalRemainingQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->where('give_st', 0)
                    ->whereNull('damage_st');

        
        // totalRemaining
        $totalRemaining        = $totalRemainingQuery->count();
        $totalRemainingAmmount = $totalRemainingQuery->sum('unit_price');
        if($totalRemainingAmmount > 0) { 
            $remainingAmmountUnit  = round($totalRemainingAmmount/$totalRemaining);
        }else{
            $remainingAmmountUnit = 0;
        }


        // totalBroughtForward query
        $totalBroughtForwardQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
        ->where('cat_id', $sort_by_category)
        ->whereDate('created_at', '<=', $sort_by_startDate)
        ->where('give_st', 0)
        ->whereNull('damage_st');

        // totalBroughtForward
        
        $totalBroughtForward        = $totalBroughtForwardQuery->count();
        $totalBroughtForwardAmmount = $totalBroughtForwardQuery->sum('unit_price');
        if($totalBroughtForwardAmmount > 0) { 
            $broughtForwardAmmountUnit  = round($totalBroughtForwardAmmount/$totalBroughtForward);
        }else{
            $broughtForwardAmmountUnit = 0;
        }

              

        $allData = [
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
           'remainingAmmountUnit'    => $remainingAmmountUnit,
           'totalRemainingAmmount'   => $totalRemainingAmmount,
           

           'totalBroughtForward'          => $totalBroughtForward,
           'broughtForwardAmmountUnit'    => $broughtForwardAmmountUnit,
           'totalBroughtForwardAmmount'   => $totalBroughtForwardAmmount,
           

        ];

        return $allData;

    }




}
