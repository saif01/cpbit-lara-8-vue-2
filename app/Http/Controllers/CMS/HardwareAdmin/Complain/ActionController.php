<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareRemarks;
use App\Http\Controllers\Common\ImageUpload;
use App\Models\Cms\Hardware\HardwareDamaged;
use App\Models\Cms\Hardware\HardwareDelivery;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;
use App\Http\Controllers\CMS\Email\Hardware\EmailStore;

class ActionController extends Controller
{
    use ImageUpload;

    //action
    public function action($id){
        $allData = HardwareComplain::with('makby', 'category', 'subcategory', 'remarks', 'remarks.makby', 'remarks.mail', 'damage', 'damage.makby', 'ho_remarks', 'ho_remarks.makby', 'ho_remarks.mail', 'delivery', 'delivery.mail', 'delivery.makby')  
        ->where('id', $id)
        ->first();

        return response()->json($allData);
    }


    // action_remarks
    public function action_remarks(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'comp_id'   => 'required',
            'process'   => 'required',
            'details'   => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;
        $process = $request->process;
        if($request->delivery == 'Deliverable'){
            $process = 'Deliverable';
        }
        

        $remarks_data = new HardwareRemarks();

        // Store in Application Complain tbl
        $complain_data = HardwareComplain::find($comp_id);
        $complain_data->process      = $process;

        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $remarks_data->document     = $document_full_name;
        }

        $remarks_data->comp_id      = $comp_id;
        $remarks_data->process      = $process;
        $remarks_data->details      = $request->details;
        $remarks_data->created_by   = Auth::user()->id;
       
        $success = $remarks_data->save();
        // Store in Application Complain tbl  
        $success2 = $complain_data->save();


        // Damageded or partial damaged
        if($process == 'Damaged' || $process == 'Partial Damaged'){

            $damaged_data  = new HardwareDamaged();

            $damaged_data->comp_id         = $comp_id;
            $damaged_data->damaged_type    = $process;
            $damaged_data->damaged_reason  = $request->damaged_reason;
            $damaged_data->applicable_type = $request->applicable_type;
            $damaged_data->created_by      = Auth::user()->id;
            $damaged_data->save();

        }

        // For email
        if($process == 'Damaged' || $process == 'Partial Damaged' || $process == 'Closed' || $process == 'Deliverable'){
            //ScheduleEmailCmsHardware::STORE($complain_data, $remarks_data);
            EmailStore::StorMailAdminAction($comp_id, $remarks_data->id, $damaged_data->id ?? null);
        }


        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // action_damaged
    public function action_damaged(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'comp_id'       => 'required',
            'rec_name'      => 'required',
            'rec_contact'   => 'required',
            'rec_position'  => 'required',
            'details'       => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;
        $process = 'Closed';

       
        $product_id_arr = $request->product_id;
        if($product_id_arr){
            $product_id_text = implode(",", $product_id_arr);
        }

        

        //dd($product_id_arr, $product_id_text, $request->product_id); 


        $rec_name       = $request->rec_name;
        $rec_contact    = $request->rec_contact;
        $rec_position   = $request->rec_position;

        $remarks_data = new HardwareRemarks();

        // Store in Application Complain tbl
        $complain_data = HardwareComplain::find($comp_id);
        $complain_data->process      = $process;
        

        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $remarks_data->document     = $document_full_name;
        }

        $remarks_data->comp_id      = $comp_id;
        $remarks_data->process      = $process;
        $remarks_data->details      = $request->details;
        $remarks_data->created_by   = Auth::user()->id;
       
        $success = $remarks_data->save();
        // Store in Application Complain tbl 
        $success2 = $complain_data->save();


        // Damageded or partial damaged_data
        $damaged_data  = HardwareDamaged::where('comp_id', $comp_id)->first();

        $damaged_data->rep_pro_id      = $product_id_text;
        $damaged_data->rec_name        = $rec_name;
        $damaged_data->rec_contact     = $rec_contact;
        $damaged_data->rec_position    = $rec_position;
        $damaged_data->created_by      = Auth::user()->id;
        $damaged_data->save();

        // sync damaged replaced product record
        if($product_id_arr){
            $damaged_data->replace_product()->sync($product_id_arr);
        }
        
        // Complain User 
        $user_data = User::find($complain_data->user_id);


        foreach($product_id_arr as $product_id){
            // Update inventory New Product table 
            $inventory_new_data = InventoryNewProduct::find($product_id);
            $inventory_new_data->give_st = 1;
            $inventory_new_data->save();

            // Update inventory Old Product table 
            $inventory_old_data = new InventoryOldProduct();
            $inventory_old_data->new_pro_id        = $product_id;
            $inventory_old_data->comp_id           = $request->comp_id; //add complain id
            $inventory_old_data->cat_id            = $inventory_new_data->cat_id;
            $inventory_old_data->subcat_id         = $inventory_new_data->subcat_id;
            $inventory_old_data->name              = $inventory_new_data->name;
            $inventory_old_data->serial            = $inventory_new_data->serial;
            $inventory_old_data->operation_id      = $request->operation_id;
            //  from user tbl
            $inventory_old_data->business_unit     = $user_data->business_unit;
            $inventory_old_data->office            = $user_data->zone_office;

            $inventory_old_data->rec_name          = $rec_name;
            $inventory_old_data->rec_contact       = $rec_contact;
            $inventory_old_data->rec_position      = $rec_position;
            
            $inventory_old_data->created_by = Auth::user()->id;
            //$inventory_old_data->save();
        }

        
        EmailStore::StorMailAdminAction($comp_id, $remarks_data->id, $damaged_data->id ?? null);

        // For email
        //ScheduleEmailCmsHardware::STORE_DAMAGED_REPLACE($complain_data, $remarks_data, $damaged_data);

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // action_quotation
    public function action_quotation(Request $request){

        //Validate
        $this->validate($request,[
            'comp_id'       => 'required',
            'details'       => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;

        $remarks_data = new HardwareRemarks();
        // Damageded or partial damaged
        $data2  = HardwareDamaged::where('comp_id', $comp_id)->first();
        $data2->apply_quotation = $request->details;

       
        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $remarks_data->document     = $document_full_name;
            // For Damaged Tbl
            $data2->document     = $document_full_name;
        }

        $remarks_data->comp_id      = $comp_id;
        $remarks_data->process      = 'Damaged Quotation';
        $remarks_data->details      = $request->details;
        $remarks_data->created_by   = Auth::user()->id;
       
        // Remarks tbl
        $success = $remarks_data->save();
        // damaged tbl
        $success = $data2->save();

        // For email
        EmailStore::DamageQuotationAdminAction($comp_id, $remarks_data->id, $damaged_data->id ?? null);

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // action_delivery
    public function action_delivery(Request $request){

        //dd($request->all());

        //Validate
        $this->validate($request,[
            'comp_id'       => 'required',
            'rec_name'      => 'required',
            'rec_contact'   => 'required',
            'rec_position'  => 'required',
            'details'       => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;

        $delivery_data = new HardwareDelivery();

        // Store in Application Complain tbl
        $complain_data = HardwareComplain::find($comp_id);
        $complain_data->process   = 'Closed';

    
        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            // For Damaged Tbl
            $delivery_data->document     = $document_full_name;
        }

        $delivery_data->comp_id      = $comp_id;
        $delivery_data->rec_name     = $request->rec_name;
        $delivery_data->rec_contact  = $request->rec_contact;
        $delivery_data->rec_position = $request->rec_position;
        $delivery_data->details      = $request->details;
        $delivery_data->created_by   = Auth::user()->id;
    
        // delivery tbl
        $success = $delivery_data->save();
        // omplain tbl
        $success = $complain_data->save();

        // For email
        EmailStore::DeliveryAdminAction($comp_id, $delivery_data->id, $damaged_data->id ?? null);

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


}

