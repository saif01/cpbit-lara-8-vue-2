<?php

namespace App\Http\Controllers\PBI\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pbi\PbiFarmAquaSale;
use App\Models\Pbi\PbiFarmAquaPurchase;
use App\Models\Pbi\PbiFarmPoultryPurchase;
use App\Models\Pbi\PbiFarmPoultrySale;

use App\Models\Pbi\PbiFoodFurtherSale;
use App\Models\Pbi\PbiFoodSlaughterSale;

use App\Models\Pbi\PbiFeedProduction;
use App\Models\Pbi\PbiFeedPurchase;
use App\Models\Pbi\PbiFeedSale;

use App\Models\Pbi\PbiExpense;

class ShowController extends Controller
{

    public function test(Request $request){
        dd($request->all());
    }

    //***************************************************//
    //***************************************************//
    //********************Start Farm *********************//
    //***************************************************//
    //***************************************************//

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
   


    //***************************************************//
    //***************************************************//
    //********************End Farm *********************//
    //***************************************************//
    //***************************************************//






    //***************************************************//
    //***************************************************//
    //********************Start Food *********************//
    //***************************************************//
    //***************************************************//

    // foodFurtherSales
    public function foodFurtherSales(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFoodFurtherSale::select('sale_date as Sale Date',
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
        
        
       // return BiFoodFurtherSale::get();
       $allData = $query ->orderBy('sale_date', 'asc')
        ->orderBy('customer_code', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

    }


    // foodSlaughterSales
    public function foodSlaughterSales(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFoodSlaughterSale::select('sale_date as Sale Date',
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
            'product_type as Product Type',
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

    //***************************************************//
    //***************************************************//
    //********************End Food *********************//
    //***************************************************//
    //***************************************************//





    //***************************************************//
    //***************************************************//
    //********************Start Feed *********************//
    //***************************************************//
    //***************************************************//

    // feedProduction
    public function feedProduction(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFeedProduction::select('production_date as Production Date',
            'plant as Plant',
            'production_line as Production Line',
            'production_no as Production No',
            'brand_name as Brand Name',
            'product_code as Product Code',
            'product_name as Product Name',
            'packing_size as Packing Size',
            'shift1_q as Shift1 Q',
            'shift1_w as Shift1 W',
            'shift2_q as Shift2 Q',
            'shift2_w as Shift2 W',
            'shift3_q as Shift3 Q',
            'shift3_w as Shift3 W',
        );

       
        // Start and end by date
        if( strtotime($start) > strtotime($end) ){
            return 'Error date !! start: '. $start . ' ,End: '. $end;
        }

        // Start end query
        $query->whereDate('production_date','<=', $end)
        ->whereDate('production_date','>=', $start);
        
        
       // return BiFarmPoultrySale::get();
       $allData = $query ->orderBy('production_date', 'asc')
        ->orderBy('production_no', 'asc')
        ->orderBy('product_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 
 
    }

    // feedPurchase
    public function feedPurchase(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiFeedPurchase::select('purchase_date as Purchase Date',
            'plant as Plant',
            'vendor_code as Vendor Code',
            'vendor_name as Vendor Name',
            'product_code as Product Code',
            'product_name as Product Name',
            'product_category as Product Category',
            'product_group as Product Group',
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

    // feedSales
    public function feedSales(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        $product_group = $request->product_group ?? null;
        $product_breed_type = $request->product_breed_type ?? null;
        

        // dd($days,$start, $end);
        $query = PbiFeedSale::select('sale_date as Sale Date', 
            'business_area as Business Area',
            'business_place as Business Place', 
            'customer_code as Customer Code',
            'customer_name as Customer Name',
            'customer_group as Customer Group',
            'customer_country as Customer Country',
            'customer_zone as Customer Zone',
            'customer_area as Customer Area',
            'customer_district as Customer District',
            'district_code as District Code',
            'district_name as District Name',
            'product_code as  Product Code',
            'product_name as Product Name',
            'product_brand as Product Brand',
            'product_type as Product Type',
            'product_phase as Product Phase',
            'product_breed as Product Breed',
            'product_breed_type as Product Breed Type',
            'product_group as Product Group',
            'quantity as Quantity',
            'weight as Weight',
            'amount as Amount'
        );

        if( !empty( $product_group) ){
            $query->where('product_group', $product_group); 
        }

        if( !empty( $product_breed_type) ){
            $query->where('product_breed_type', $product_breed_type); 
        }

       
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

    //***************************************************//
    //***************************************************//
    //********************End Feed *********************//
    //***************************************************//
    //***************************************************//






    //***************************************************//
    //***************************************************//
    //********************End Expense *********************//
    //***************************************************//
    //***************************************************//
    
    // expense
    public function expense(Request $request){

        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // dd($days,$start, $end);

        $query = PbiExpense::select('expense_date as Expense Date',
            'business as Business',
            'business_unit as Business Unit',
            'operation as Operation',
            'department as Department',
            'unit_level_code as Unit Level Code',
            'unit_level_name as Unit Level Name',
            'control_account_code as Control Account Code',
            'control_account_name as Control Account Name',
            'account_code as Account Code',
            'account_name as Account Name',
            'expense_type as Expense Type',
            'expense_group as Expense Group',
            'amount as Amount'
        );

       
        // Start and end by date
        if( strtotime($start) > strtotime($end) ){
            return 'Error date !! start: '. $start . ' ,End: '. $end;
        }

        // Start end query
        $query->whereDate('expense_date','<=', $end)
        ->whereDate('expense_date','>=', $start);
        
        
       // return BiFarmPoultrySale::get();
       $allData = $query ->orderBy('expense_date', 'asc')
        ->orderBy('control_account_code', 'asc')
        ->orderBy('account_code', 'asc')
        ->get();
      
       // dd($allData);

       return $allData; 

    }
    
    //***************************************************//
    //***************************************************//
    //********************End Feed *********************//
    //***************************************************//
    //***************************************************//






  
    
}
