<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tinify;

class TinifyController extends Controller
{
    public function index()
    {
        \Tinify\setKey("WFe6BKhMrXEXCJdFPLJf5OUXVIoBLWz9");
        // https://viblo.asia/p/toi-uu-dung-luong-anh-trong-ung-dung-cua-ban-voi-tinify-6J3ZgBqqKmB
        // https://tinypng.com/developers
        // get file
        // $source = \Tinify\fromUrl("https://tinypng.com/images/panda-happy.png");
        // $source->toFile("optimized.jpg");

        // resize fit
        $source = \Tinify\fromFile("image/large/image_2.jpg");
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => 150,
            "height" => 100
        ));
        $resized->toFile("image/resize/image_2_fit.jpg");

        // resize scale
        $resized = $source->resize(array(
            "method" => "scale",
            "width" => 150
            // "height" => 100
        ));
        $resized->toFile("image/resize/image_2_scale.jpg"); 
    }
}
