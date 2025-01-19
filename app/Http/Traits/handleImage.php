<?php

namespace App\Http\Traits;


use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

trait handleImage
{

    public function uploadImage($image , $path, $width = null, $height = null) {

        $fileName = date('ymhis').  '.' . $image->getClientOriginalExtension();
        $image->move(public_path($path), $fileName);

        return $path . '/' .  $fileName;
    }

}
