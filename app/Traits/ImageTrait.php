<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;



trait ImageTrait {

    protected  $fieldname='image';

    /** Upload image
     * @param string $filename
     * @param string $directory
     * @return $this|false|string
     */
    public function uploadImage($request, $filename, $directory, $fieldname=null)
    {
        $fieldname = ($fieldname == null) ? $this->fieldname : $fieldname;
        if($request->has($fieldname)){
            if (!$request->file($fieldname)->isValid()) {
                session()->flash('Invalid Image!');
                return redirect()->back()->withInput();
            }
            $image = $request->file($fieldname);
            if($image->move(public_path($directory), 
                    $filename.'.'.$image->getClientOriginalExtension())){
                return  $filename.'.'.$image->getClientOriginalExtension();
            }
            else{
                return null;
            }
        }
        return null;
    }

    /** Upload images
     * @param string $filename
     * @param string $directory
     * @return $this|false|string
     */
    public function uploadImages($request, $filename, $directory, $fieldname=null)
    {
        $fieldname = ($fieldname == null) ? $this->fieldname : $fieldname;
        $paths = [];
        if($request->has($fieldname)){
            $images = $request->file($fieldname);
            foreach($images as $image){
                $imgName =   $filename.'_'.uniqid();
                if($image->move(public_path($directory), 
                       $imgName.'.'.$image->getClientOriginalExtension())){
                    $paths[] = $imgName.'.'.$image->getClientOriginalExtension();
                }

            }
            return $paths;
        }
        return null;
    }

     /** Update image
     * @param string $filename
     * @param string $directory
     * @return $this|false|string
     */
    public function updateImage($request, $filename, $directory, $oldPath=null, $fieldname=null)
    {
        $fieldname = ($fieldname == null) ? $this->fieldname : $fieldname;
        if($request->has($fieldname)){
            if (!$request->file($fieldname)->isValid()) {
                session()->flash('Invalid Image!');
                return redirect()->back()->withInput();
            }
            if(File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }
            $image = $request->file($fieldname);
            if($image->move(public_path($directory), 
                    $filename.'.'.$image->getClientOriginalExtension())){
                return  $filename.'.'.$image->getClientOriginalExtension();
            }
            else{
                return null;
            }
        }
        return null;
    }

    /**
     * Delete image
     * @param string $path
     */
    public function deleteImage($path)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }

}