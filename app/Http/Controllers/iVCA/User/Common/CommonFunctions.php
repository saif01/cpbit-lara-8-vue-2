<?php

namespace App\Http\Controllers\iVCA\User\Common;
use Illuminate\Support\Str;

trait CommonFunctions {

    
    // Image Uplpoad By name 
    public function imageUplaodByName($currentImage, $oldImage, $imagePath, $imagePathSm=null){

        // Image Path
        if( $imagePathSm == null ){
            $imagePathSm = $imagePath . 'small/';
        }

        // Delete Image
        if(!empty($oldImage)){
            //Delete Old File
            if (file_exists($imagePath . $oldImage)){
                unlink( $imagePath . $oldImage );
            }
            if (file_exists($imagePathSm . $oldImage)){
                unlink( $imagePathSm . $oldImage );
            }
        }
        
        // Random srting
        $randomName = Str::random(6);
        // Final Name
        $name = $randomName . time().'.' . explode('/', explode(':', substr($currentImage, 0, strpos($currentImage, ';')))[1])[1];
        // Original Image Save
        \Image::make($currentImage)
        ->save($imagePath.$name);
        // Resized image save
        \Image::make($currentImage)
        ->resize(300, 200)
        ->save($imagePathSm.$name);

        return $name;
        
    }



}