<?php

namespace App\Http\Traits;

use App\Driver;
use App\ImageManager;

trait handleImage
{

    public function uploadImage($image , $path, $width = null, $height = null) {
        $manager = new ImageManager(new Driver());
        $image_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image= $manager->read($image);
        $image->toJpeg(80)->save(public_path($path). $image_gen);

        if ($width != null) {
            if($height != null){
                $image->resize($width, $height);
            }else {

                $image->resize($width, $width);
            }
        }

        return $path . $image_gen;
    }

}
