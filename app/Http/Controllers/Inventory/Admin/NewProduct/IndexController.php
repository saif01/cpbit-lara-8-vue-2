<?php

namespace App\Http\Controllers\Inventory\Admin\NewProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;
use App\Http\Controllers\Common\ImageUpload;

class IndexController extends Controller
{
    use ImageUpload;

    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->where('give_st', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

   
    // store
    public function store(Request $request){
        //dd($request->all());

        //Validate
        $this->validate($request,[
            'cat_id'        =>  'required',
            'subcat_id'     =>  'required',
            'name'          =>  'required',
            'serial'        =>  'required|max:200|unique:inventory_new_products',
            'po_number'     =>  'nullable|max:200|unique:inventory_new_products',
            'invoice_num'      =>  'nullable|max:200|unique:inventory_new_products',
            'req_payment_num'  =>  'nullable|max:200|unique:inventory_new_products',
            'purchase'      =>  'required',
            'remarks'       =>  'required|min:10|max:2000',
        ]);

        $data = new InventoryNewProduct();



        $documentPath = 'images/inventory/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath, $request->po_number.'_');
            $data->document     = $document_full_name;
        }

        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->name         = $request->name;
        $data->serial       = $request->serial;
        $data->remarks      = $request->remarks;
        $data->purchase     = $request->purchase;
        $data->warranty     = $request->warranty;
        $data->invoice_num     = $request->invoice_num;
        $data->bill_submit     = $request->bill_submit;
        $data->req_payment_num = $request->req_payment_num;
        $data->po_number    = $request->po_number;
        
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // update
    public function update(Request $request){

        // dd($request->all());

        //Validate
        $this->validate($request,[
            'cat_id'        =>  'required',
            'subcat_id'     =>  'required',
            'name'          =>  'required',
            'serial'        =>  'required|max:200|unique:inventory_new_products,serial,'.$request->id,
            'po_number'     =>  'nullable|max:200|unique:inventory_new_products,po_number,'.$request->id,
            'invoice_num'     =>  'nullable|max:200|unique:inventory_new_products,invoice_num,'.$request->id,
            'req_payment_num' =>  'nullable|max:200|unique:inventory_new_products,req_payment_num,'.$request->id,
            'purchase'      =>  'required',
            'remarks'       =>  'required|min:10|max:2000',
        ]);

        $data = InventoryNewProduct::find($request->id);


        $documentPath = 'images/inventory/';
        $document     = $request->file('document');
        $old_doc      = $data->document; 

        //dd($document, $old_doc, $request->all());

        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath, $request->po_number.'_');
            $data->document     = $document_full_name;
        }
    
        

        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->name         = $request->name;
        $data->serial       = $request->serial;
        $data->remarks      = $request->remarks;
        $data->purchase     = $request->purchase;
        $data->warranty     = $request->warranty;
        $data->invoice_num     = $request->invoice_num;
        $data->bill_submit     = $request->bill_submit;
        $data->req_payment_num = $request->req_payment_num;
        $data->po_number    = $request->po_number;
        
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();


        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // destroy_temp
    public function destroy_temp(Request $request){

        $data       =  InventoryNewProduct::find($request->id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);
      
    }



     //office
    public function office(){

        $office = User::where('status', 1)
            ->whereNotNull('zone_office')
            ->select('zone_office','id')
            ->orderBy('zone_office')
            //->distinct('zone_office')
            ->groupBy('zone_office')
            ->get()
            ->toArray();
            


        $business_unit = User::where('status', 1)
            ->whereNotNull('business_unit')
            ->select('business_unit','id')
            ->orderBy('business_unit')
            //->distinct('business_unit')
            ->groupBy('business_unit')
            ->get()
            ->toArray();

        $operation = InventoryOperation::select('id', 'name')->get()->toArray();


        return response()->json(['office'=>$office, 'business_unit'=>$business_unit, 'operation'=>$operation]);

    }


    // deliver
    public function deliver(Request $request){

        //Validate
        $this->validate($request,[
            'cat_id'            =>  'required',
            'subcat_id'         =>  'required',
            'name'              =>  'required',
            'serial'            =>  'required|max:200|unique:inventory_new_products,serial,'.$request->id,
            'remarks'           =>  'required',
            'operation_id'      =>  'required',
            'business_unit'  =>  'required',
            'office'         =>  'required',
            'rec_name'          =>  'required',
            'rec_contact'       =>  'required',
            'rec_position'      =>  'required',
        ]);

        // giveen status chnage
        $data           =  InventoryNewProduct::find($request->id);
        $data->give_st  = 1;
        $success        = $data->save();


        $data2 = new InventoryOldProduct();

        $data2->new_pro_id        = $request->id;
        $data2->cat_id            = $request->cat_id;
        $data2->subcat_id         = $request->subcat_id;
        $data2->name              = $request->name;
        $data2->serial            = $request->serial;
        $data2->operation_id      = $request->operation_id;
        $data2->business_unit     = $request->business_unit;
        $data2->office            = $request->office;
        $data2->rec_name          = $request->rec_name;
        $data2->rec_contact       = $request->rec_contact;
        $data2->rec_position      = $request->rec_position;
        
        $data2->created_by = Auth::user()->id;
        $success           = $data2->save();

        return response()->json('success', 200);


    }
}
