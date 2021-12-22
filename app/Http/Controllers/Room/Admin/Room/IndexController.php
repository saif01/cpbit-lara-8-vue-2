<?php

namespace App\Http\Controllers\Room\Admin\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room\Room;
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

        $allData = Room::with('makby')
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
            'name'      =>  'required|unique:rooms|max:50',
            'capacity'  =>  'required',
            'remarks' =>  'nullable|max:1000',
        ]);

        $data = new Room();



        $imagePath      = 'images/room/';
        // Save Image 
        $current_image  = $request->image; 
        if(!empty($current_image)){
            $imgName= $this->imageUplaodByName($current_image, null, $imagePath); 
            $data->image = $imgName;
        }

        // Save Image 2
        $current_image2  = $request->image2; 
        if(!empty($current_image2)){
            $imgName2= $this->imageUplaodByName($current_image2, null, $imagePath); 
            $data->image2 = $imgName2;
        }

        // Save Image 3
        $current_image3  = $request->image3; 
        if(!empty($current_image3)){
            $imgName3= $this->imageUplaodByName($current_image3, null, $imagePath); 
            $data->image3 = $imgName3;
        }

    
        $data->name       = $request->name;
        $data->capacity   = $request->capacity;
        $data->projector  = $request->projector;
        $data->remarks    = $request->remarks;
        
        $data->status     = 0;
        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

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

        //Validate
        $this->validate($request,[
            'name'     =>  'required|string|max:1000|unique:rooms,name,'.$id,
            'capacity' =>  'required',
            'remarks'  =>  'nullable|max:1000',
        ]);

        $data = Room::find($id);


        $imagePath      = 'images/room/';
        // Save Image 
        $current_image  = $request->image; 
        $old_image      = $data->image;
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }

        // Save Image 2
        $current_image2  = $request->image2;
        $old_image2      = $data->image2; 
        if(!empty($current_image2 != $old_image2)){
            $imgName2= $this->imageUplaodByName($current_image2, $old_image2, $imagePath); 
            $data->image2 = $imgName2;
        }
        $current_image3  = $request->image3; 

        // Save Image 3
        $current_image3  = $request->image3; 
        $old_image3      = $data->image3;
        if($current_image3 != $old_image3){
            $imgName3= $this->imageUplaodByName($current_image3, $old_image, $imagePath); 
            $data->image3 = $imgName3;
        }

      
        $data->name       = $request->name;
        $data->capacity   = $request->capacity;
        $data->projector  = $request->projector;
        $data->remarks    = $request->remarks;
        
        $data->status     = 0;
        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

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
        $data       =  Room::find($id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);
      
    }

    // destroy
    public function destroy($id)
    {
        $data       =  Room::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  Room::find($id);
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