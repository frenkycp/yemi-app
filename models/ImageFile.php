<?php

namespace app\models;

use yii\base\Model;

class ImageFile extends Model
{
    public static function resize_crop_image($source_file, $dst_dir, $quality, $long_side){
	    $imgsize = getimagesize($source_file);
	    $width = $imgsize[0];
	    $height = $imgsize[1];
	    $mime = $imgsize['mime'];
	    $compare = round($width / $height);

	    //check if landscape or portrait
	    if ($width > $height) {
	    	$max_width = $long_side;
	    	$max_height = ($height / $width) * $max_width;
	    } else {
	    	$max_height = $long_side;
	    	$max_width = ($width / $height) * $max_height;
	    }
	    
	    switch($mime){
	        case 'image/gif':
	            $image_create = "imagecreatefromgif";
	            $image = "imagegif";
	            $quality = 10;
	            break;

	        case 'image/png':
	            $image_create = "imagecreatefrompng";
	            $image = "imagepng";
	            $quality = 9;
	            break;

	        case 'image/jpeg':
	            $image_create = "imagecreatefromjpeg";
	            $image = "imagejpeg";
	            //$quality = 30;
	            break;



	        default:
	            return false;
	            break;
	    }

	    //$max_width = $width;
	    //$max_height = $height;
	    $dst_img = imagecreatetruecolor($max_width, $max_height);
	    $src_img = $image_create($source_file);

	    $width_new = $height * $max_width / $max_height;
	    $height_new = $width * $max_height / $max_width;
	    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
	    if($width_new > $width){
	        //cut point by height
	        $h_point = (($height - $height_new) / 2);
	        //copy image
	        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
	    }else{
	        //cut point by width
	        $w_point = (($width - $width_new) / 2);
	        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
	    }

	    $image($dst_img, $dst_dir, $quality);

	    if($dst_img)imagedestroy($dst_img);
	    if($src_img)imagedestroy($src_img);
	}
}