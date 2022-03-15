<?php

namespace App\Http\Controllers\PBI\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pbi\PbiFarmAquaSale;
use App\Models\Pbi\PbiFarmAquaPurchase;
use App\Models\Pbi\PbiFarmPoultryPurchase;
use App\Models\Pbi\PbiFarmPoultrySale;

class ShowController extends Controller
{

    public function test(Request $request){
        dd($request->all());
    }

    //********************Start farm *********************//

    // farmAquaPurchase
    public function farmAquaPurchase(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);
        $query = PbiFarmAquaPurchase::select('purchase_date as Purchase Date',
            'business_area as Business Area',
            'business_place as Business Place',
            'vendor_code as Vendor Code',
            'vendor_name as Vendor Name',
            'vendor_group as Vendor Group',
            'product_code as Product Code',
            'product_name as Product Name',
            'product_group as Product Group',
            'product_line as Product Line',
            'measurement as Measurement',
            'quantity as Quantity',
            'weight as Weight',
            'amount as Amount'
        );

      
        // Start and end by date
        if( strtotime($start) > strtotime($end) ){
            return 'Error date !! start: '. $start . ' ,End: '. $end;
        }

        // Start end query
        $query->whereDate('purchase_date','<=', $end)
        ->whereDate('purchase_date','>=', $start);
        

       // return BiFarmPoultrySale::get();
       $allData = $query ->orderBy('purchase_date', 'asc')
        ->orderBy('vendor_code', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

    }


    //farmAquasales
    public function farmAquasales(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFarmAquaSale::select('sale_date as Sale Date',
            'business_area as Business Area',
            'business_place as Business Place', 
            'customer_code as Customer Code',
            'customer_name as Customer Name',
            'customer_group as Customer Group',
            'district_code as District Code',
            'district_name as District Name',
            'product_code as  Product Code',
            'product_name as Product Name',
            'product_group as Product Group',
            'product_line as Product Line',
            'measurement as Measurement',
            'quantity as Quantity',
            'weight as Weight',
            'amount as Amount'
        );

        if(!empty($start) && !empty($end) ){

            // Start and end by date
            if( strtotime($start) > strtotime($end) ){
                return 'Error date !! start: '. $start . ' ,End: '. $end;
            }

            // Start end query
            $query->whereDate('sale_date','<=', $end)
            ->whereDate('sale_date','>=', $start);
        }


        
       // return BiFarmAquaSale::get();
       $allData = $query ->orderBy('sale_date', 'asc')
        ->orderBy('customer_code', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

       

       
    }


    // farmPoultryPurchase
    public function farmPoultryPurchase(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFarmPoultryPurchase::select('purchase_date as Purchase Date',
            'business_area as Business Area',
            'business_place as Business Place',
            'vendor_code as Vendor Code',
            'vendor_name as Vendor Name',
            'vendor_group as Vendor Group',
            'product_code as Product Code',
            'product_name as Product Name',
            'product_group as Product Group',
            'product_line as Product Line',
            'measurement as Measurement',
            'quantity as Quantity',
            'weight as Weight',
            'amount as Amount'
        );

       
        // Start and end by date
        if( strtotime($start) > strtotime($end) ){
            return 'Error date !! start: '. $start . ' ,End: '. $end;
        }

        // Start end query
        $query->whereDate('purchase_date','<=', $end)
        ->whereDate('purchase_date','>=', $start);
        

       // return BiFarmPoultrySale::get();
       $allData = $query ->orderBy('purchase_date', 'asc')
        ->orderBy('vendor_code', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

       

       
    }

    
    // farmPoultrySales
    public function farmPoultrySales(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFarmPoultrySale::select('sale_date as Sale Date',
            'business_area as Business Area',
            'business_place as Business Place', 
            'customer_code as Customer Code',
            'customer_name as Customer Name',
            'customer_group as Customer Group',
            'district_code as District Code',
            'district_name as District Name',
            'product_code as  Product Code',
            'product_name as Product Name',
            'product_group as Product Group',
            'product_line as Product Line',
            'measurement as Measurement',
            'quantity as Quantity',
            'weight as Weight',
            'amount as Amount'
        );

       
        // Start and end by date
        if( strtotime($start) > strtotime($end) ){
            return 'Error date !! start: '. $start . ' ,End: '. $end;
        }

        // Start end query
        $query->whereDate('sale_date','<=', $end)
        ->whereDate('sale_date','>=', $start);
        

       // return BiFarmPoultrySale::get();
       $allData = $query ->orderBy('sale_date', 'asc')
        ->orderBy('customer_code', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

    }
   


    //********************End farm *********************//




  
    
}
