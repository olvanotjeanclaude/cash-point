<?php

namespace App\Helper;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageUploadHelper
{
  static function upload($name, $directory, $file)
  {
    $dir = "uploads/" . $directory;
    if (!empty($file)) {
      if (!File::exists($dir)) {
        File::makeDirectory($dir, 0755, true);
      }

      $fileName = $name . "-" . rand(1, 9000) . "." . $file->getClientOriginalExtension();
      $path = ($dir . '/' . $fileName);
      Image::make($file->getRealPath())->save($path);
      return $dir . '/' . $fileName;
    }

    return "";
  }

  static function uploadAdvertisement($name, $directory, $file)
  {
    $dir = "front_assets/uploads/" . $directory;
    if (!empty($file)) {
      if (!File::exists($dir)) {
        File::makeDirectory($dir, 0755, true);
      }

      $fileName = $name . "-" . rand(1, 9000) . "." . $file->getClientOriginalExtension();
      $path = ($dir . '/' . $fileName);
      Image::make($file->getRealPath())->save($path);
      return $dir . '/' . $fileName;
    }

    return "";
  }
}
