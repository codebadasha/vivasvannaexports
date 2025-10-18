<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Thumbnail;

class GlobalController extends Controller
{
    public static function slugify($text, string $divider = '-'){
        
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
        return 'n-a';
        }

        return $text;
    }

    // Upload image to amazon s3 bucket
    public function uploadBucket($image,$path){

        $imagedata = $image;
        $extension = $imagedata->getClientOriginalExtension();
        $fileName = rand(1,100000000).time().'.'.$extension;
        $destinationPath = $path."/".$fileName;
        $s3 = \Storage::disk('s3');
        $s3->put($destinationPath, file_get_contents($imagedata));
        return \Storage::disk('s3')->url($destinationPath);
    }

    // Convert Date Format
    public function convertDate($date){
        $date = explode('/',$date);
        return $date[2]."-".$date[1]."-".$date[0];
    }

    // Upload image
    public function uploadImage($image,$path){

        $imagedata = $image;
        $destinationPath = 'uploads/'.$path;
        $extension = $imagedata->getClientOriginalExtension(); 
        $fileName = rand(11111,99999).'.'.$extension;
        $imagedata->move($destinationPath, $fileName);
        
        return $fileName;
    }

    public function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

    public function uploadProductImage($file,$path,$uuid,$compress = null){

        $extension_type    = $file->getClientMimeType();
        $extension         = $file->getClientOriginalExtension();
        $originalImagePath = public_path().'/temp/original';
        $thumbImagePath    = public_path().'/temp/thumb';

        $originalImageName = rand(111111111,9999999999).time().".".$extension;

        if($compress == null){
            $thumbImageName    = rand(111111111,9999999999).time().".".$extension;
            //compress image
            $tempPath          = $file->getPathName();
            $save_path_thumb   = $thumbImagePath.'/'.$thumbImageName;
            $this->compress($tempPath, $save_path_thumb, 50);

            //thumb image 
            $thumbImagePath = 'product/'.$uuid.'/'.$thumbImageName;
            $s3 = \Storage::disk('s3');
            $s3->put($thumbImagePath, file_get_contents($save_path_thumb));
            $thumbImage = \Storage::disk('s3')->url($thumbImagePath);
            $response['thumb_url'] = $thumbImage;
            unlink($save_path_thumb);
        }

        //original image
        $originalImagePath = 'product/'.$uuid.'/'.$originalImageName;
        
        $s3 = \Storage::disk('s3');
        $s3->put($originalImagePath, file_get_contents($file));
        $originalImage = \Storage::disk('s3')->url($originalImagePath);
        
        
        $response['media_url'] = $originalImage;

        

        return $response;
    }

    public function uploadProductVideo($video,$uuid){

        $basePath = public_path().'/uploads/video/';

        $file             = $video;
        $extension_type   = $file->getClientMimeType();
        $destination_path = $basePath.'original/';
        $extension        = $file->getClientOriginalExtension();
        $file_name        = date('ymdhis').".".$extension;


        //original file
        $original_path = $file->getPathName();

        //compress video
        $convertedFileName  = rand(1,100000000).time().".mp4";
        $converted_path_new = $basePath.'compressed/'.$convertedFileName;
        
        //compress video
        shell_exec("ffmpeg -i ".$original_path." -vcodec libx264 -crf 27 -preset veryfast -c:a copy ".$converted_path_new);
        
        
        //generate thumbail
        $thumbnail_path   = $basePath.'/thumb/';
        $thumbnail_image  = rand(1,100000000).time().".jpg";
        $time_to_image    = 2;
        $thumbnail_status = Thumbnail::getThumbnail($original_path,$thumbnail_path,$thumbnail_image,$time_to_image);

        $thumbnailPath = $thumbnail_path."/".$thumbnail_image;

        //thumb image 
        $thumbImagePath = 'product/'.$uuid.'/'.$thumbnail_image;
        $s3 = \Storage::disk('s3');
        $s3->put($thumbImagePath, file_get_contents($thumbnailPath));
        $thumbImage = \Storage::disk('s3')->url($thumbImagePath);


        //original image
        $videoPath = 'product/'.$uuid.'/'.$convertedFileName;
        
        $s3 = \Storage::disk('s3');
        $s3->put($videoPath, file_get_contents($converted_path_new));
        $originalImage = \Storage::disk('s3')->url($videoPath);

        $response['thumb_url'] = $thumbImage;
        $response['media_url'] = $originalImage;

        unlink($thumbnailPath);
        unlink($converted_path_new);

        return $response;
    }


    public function discount($productId,$productPrice){

        $discountProduct = DiscountProduct::where('product_id',$productId)
                                                ->whereHas('discount',function($q){ 
                                                    $date = date('Y-m-d'); 
                                                    $q->where('is_active',1); 
                                                    $q->where('is_delete',0); 
                                                    $q->where('valid_from','<=',$date); 
                                                    $q->where('valid_till','>=',$date);     
                                                })->with(['discount'])->first();

                
        $discount = !is_null($discountProduct) && !is_null($discountProduct->discount) ?  $discountProduct->discount->discount : 0.00;
        $discountId = !is_null($discountProduct) && !is_null($discountProduct->discount) ?  $discountProduct->discount_id : 0;
        $discountedPrice = 0.00;
        $amount = 0.00;

        if($discount != 0){
            $amount = $productPrice * $discount / 100;
            $discountedPrice = $productPrice - $amount;
        }

        $price['discount'] = $discount;
        $price['amount'] = $amount;
        $price['original_price'] = $productPrice;
        $price['discounted_price'] = $discountedPrice;   
        $price['discount_id'] = $discountId;   

        return $price;
    }
}
