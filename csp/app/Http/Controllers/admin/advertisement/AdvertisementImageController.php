<?php

namespace App\Http\Controllers\admin\advertisement;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Helper\ImageUploadHelper;
use App\Models\AdvertisementImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AdvertisementImageController extends Controller
{
    public function picture($id)
    {
        $c = Advertisement::where('id', $id)->count();

        if ($c != 0) {
            $data = Advertisement::where('id', $id)->get();
            $all_picture = AdvertisementImage::where('advertisement_id', $id)->orderBy('id', 'DESC')->get();

            return view('admin.advertisements.picture', ["data" => $data, 'all_picture' => $all_picture]);
        } else {
            return abort(404);
        }
    }

    public function insertPicture(Request $request)
    {
        $id = $request->route('id');

        $imageFile = $request->file('file');
        $image = (isset($imageFile)) ? ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "ad", $imageFile) : "";

        $array = [
            'advertisement_id' => $id,
            'image_url' => $image
        ];

        $insert = AdvertisementImage::create($array);
    }

    public function deletePicture($id)
    {
        $result = [];

        $c = AdvertisementImage::where('id', $id)->count();
        $data = AdvertisementImage::where('id', $id)->get();

        if ($c != 0) {
            deleteImage($data[0]["image_url"]);
            $delete = AdvertisementImage::where('id', $id)->delete();


            if ($delete) {
                $result["success"] = "Resmi başarılı bir şekilde silindi.";
                $result["type"] = "success";
                //return redirect()->route('admin.manager.index')->with('success', 'Yönetici başarılı bir şekilde silindi.');
            } else {
                $result["type"] = "error";
                $result["error"] = "Resmi silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
            }

            return response()->json($result);
        }

        return abort(404);
    }

    public function editPicture($id)
    {
        $data = AdvertisementImage::findOrFail($id);
        return view("admin.my_advertisement.edit-picure", compact("data"));
    }

    public function uploadPicture($id, Request $request)
    {
        $response = [];
        $image = $request->image;
        $isUploaded = false;

        if ($image) {
            $destinationPath = "front_assets/uploads/ad";

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image_array_1 = explode(";", $image);
            $image_array_2 = explode(",", $image_array_1[1]);
            $image_base64 = base64_decode($image_array_2[1]);

            $fileName = rand(1, 1000) . '-' . rand(1, 1000) . '.' . 'png';
            $file = $destinationPath . "/" . $fileName;

            $success = file_put_contents($file, $image_base64);

            if ($success) {
                $data = AdvertisementImage::find($id);
                if (file_exists($data->image_url)) {
                    unlink($data->image_url);
                }
                $updated = $data->update(["image_url" => $file]);

                if ($updated) {
                    $isUploaded = true;
                    $response["message"] = "Edited successfully!";
                    $response["success"] = '<img src="/' . $data->image_url . '" class="img-thumbnail" />';
                }
            }
        }

        if (!$isUploaded) {
            $response["error"] = "<p class='text-danger'>Error while uploading. Please try again!</p>";
        }

        return response()->json($response);
    }

    public function isCoverSetter(Request $request)
    {
        $id = $request->route('id');
        $parent_id = $request->route('parent_id');

        $all = $request->except('_token');
        $isCover = ($all['data'] === "true") ? 1 : 0;

        AdvertisementImage::where('id', $id)->where('advertisement_id', $parent_id)->update(['isCover' => $isCover]);
        AdvertisementImage::where('id', "!=", $id)->where('advertisement_id', $parent_id)->update(['isCover' => 0]);
    }
}
