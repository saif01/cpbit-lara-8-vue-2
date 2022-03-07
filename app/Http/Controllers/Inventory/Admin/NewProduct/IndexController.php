<?php

namespace App\Http\Controllers\Inventory\Admin\NewProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryNewProduct;
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
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'cat_id'        =>  'required',
            'subcat_id'     =>  'required',
            'name'          =>  'required',
            'serial'        =>  'required|max:200|unique:inventory_new_products',
            'po_number'     =>  'nullable|max:200|unique:inventory_new_products',
            'purchase'      =>  'required',
            'remarks'       =>  'required|min:10|max:2000',
        ]);

        $data = new InventoryNewProduct();



        $documentPath = 'images/inventory/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->name         = $request->name;
        $data->serial       = $request->serial;
        $data->remarks      = $request->remarks;
        $data->purchase     = $request->purchase;
        $data->warranty     = $request->warranty;
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
    public function update(Request $request, $id){

        //dd($request->all(), $id);

        //Validate
        $this->validate($request,[
            'cat_id'        =>  'required',
            'subcat_id'     =>  'required',
            'name'          =>  'required',
            'serial'        =>  'required|max:200|unique:inventory_new_products,serial,'.$id,
            'po_number'     =>  'nullable|max:200|unique:inventory_new_products,po_number,'.$id,
            'purchase'      =>  'required',
            'remarks'       =>  'required|min:10|max:2000',
        ]);

        $data = InventoryNewProduct::find($id);


        $documentPath = 'images/inventory/';
        $document     = $request->file('document');
        $old_doc      = $data->document; 

        dd( $document, $old_doc );
        // Direct any file store
        if ($document != $old_doc) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $data->document     = $document_full_name;
        }

        $data->cat_id       = $request->cat_id;
        $data->subcat_id    = $request->subcat_id;
        $data->name         = $request->name;
        $data->serial       = $request->serial;
        $data->remarks      = $request->remarks;
        $data->purchase     = $request->purchase;
        $data->warranty     = $request->warranty;
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
    public function destroy_temp($id)
    {
        $data       =  InventoryNewProduct::find($id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);
      
    }

    // destroy
    public function destroy($id)
    {
        $data       =  InventoryNewProduct::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  InventoryNewProduct::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }
}
