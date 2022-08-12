<?php
/**
 * Created by PhpStorm.
 * User: rupesh
 * Date: 10/9/2018
 * Time: 4:05 PM
 */

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{

    /**
     * Process image upload for both store() and update() method
     *
     * @param $image
     * @param null $image_name Decides either update() request has existing image or not
     */


    public function uploadImage($image, $image_name = null,$folder = null){

        if($image){

            $folderName = $folder ?? $this->folder;
            $folder_path = 'images'.DIRECTORY_SEPARATOR.$folderName;
            $this->image_name = (time().mt_rand(4100, 9999).'_'.$image->getClientOriginalName());


            //create folder if not exist
            if(!file_exists($folder_path)){
                File::makeDirectory($folder_path, 0775, true);
            }
            //Now move image to folder
            $image->move($folder_path, $this->image_name);

            if($image_name){
                if($image_name){
                    $this->removeImage($image_name);
                }
            }
        } else {
            $this->image_name = $image_name;
        }
    }

    public function removeImage($image_name){
        $folder_path = 'images'.DIRECTORY_SEPARATOR.$this->folder;
        if($image_name){
            if(file_exists($folder_path.DIRECTORY_SEPARATOR.$image_name)){
                unlink($folder_path.DIRECTORY_SEPARATOR.$image_name);
            }
        }

    }
    public function uploadImageThumbs($image, $request_for = 'store', $image_name = null){
        if($image){
            $image_dimensions = $this->image_dimensions;
            foreach ($image_dimensions as $image_dimension){
                $img = Image::make($this->folder.DIRECTORY_SEPARATOR.$this->image_name)->resize($image_dimension['width'].'_'.$image_dimension['height']);
                $img->save($this->folder_path.DIRECTORY_SEPARATOR.$image_dimension['width'].'_'.$image_dimension['height'].'_'.$this->image_name, 75);
            }


            if($request_for == 'update'){
                foreach ($image_dimensions as $image_dimension){
                    if(file_exists($this->folder_path.DIRECTORY_SEPARATOR.$image_dimension['width'].'_'.$image_dimension['height'].'_'.$this->image_name)){
                        unlink($this->folder_path.DIRECTORY_SEPARATOR.$image_dimension['width'].'_'.$image_dimension['height'].'_'.$this->image_name);
                    }
                }
            }
        }
    }

    public function removeImageThumbs($image_name, $dimensions = null){

        if($image_name){
            $image_dimensions = $dimensions?$dimensions:$this->image_dimensions;
            foreach ($image_dimensions as $image_dimension){
                if(file_exists($this->folder_path.DIRECTORY_SEPARATOR.$image_dimension['width'].'_'.$image_dimension['height'].'_'.$image_name)){
                    unlink($this->folder_path.DIRECTORY_SEPARATOR.$image_dimension['width'].'_'.$image_dimension['height'].'_'.$image_name);
                }
            }
        }

    }

    public function getImage($folder_name = null,$imageName = null)
    {
        $folder_name = $folder_name ?? $this->getTable();
        $image = $this->image ?? $imageName;

        $imagePath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $image;

        if (!empty($image) && file_exists($imagePath)) {
            return asset( 'images' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $image);
        }
        $this->getDefaultImage();
    }

    public function getDefaultImage()
    {
       $model =  get_class($this);
       dd($model);
    }

    public static function getFromTrait() :string
    {
        return 'this is from trait';
    }

}
