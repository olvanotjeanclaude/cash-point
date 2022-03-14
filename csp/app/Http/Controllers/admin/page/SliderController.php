<?php

namespace App\Http\Controllers\admin\page;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    private $uploadPath = "front/sliders";

    public function index()
    {

        $sliders = Slider::orderBy("id", "desc")->get();
        return view("admin.slider.index", compact("sliders"));
    }

    public function create()
    {
        return view("admin.slider.create");
    }

    public function store(Request $request)
    {
        $all = $request->except("_token");
        $insterted = false;
      

        if (!isset($all["slider"]) || count($all["slider"]) == 0) {
            return back()->with("error", "Lütfen resimleri eklemeyi unutmayın!")->withInput();
        }
      

        foreach ($all["slider"] as $slider) {
            $image = (isset($slider['image'])) ? ImageUploadHelper::upload(rand(1, 9000), $this->uploadPath, $slider['image']) : "";
            $slider["user_id"] = Auth::user()->id;
            $slider["image"] = $image;

            $insterted = Slider::create($slider);
        }

        if ($insterted) {
            return redirect()->route("admin.sliders.index")->with('success', 'Slider başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Slider kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function show($id)
    {
        $data = Slider::find($id);

        $slider = [
            "title" => "Slider",
            "description" => "Slider'in tanımı tanımlanmamıştır!",
            "image" => ""
        ];

        if ($data) {
            $slider["title"] = $data->title != null ? $data->title : "data $data->id";
            $slider["description"] = $data->description != null ? $data->description : $slider["description"];
            $slider["image"] = $data->image;
        }

        return view("admin.slider.modal.show-slider", compact("slider"));
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view("admin.slider.modal.edit-slider", compact("slider"));
    }

    public function update(Request $request)
    {
        $id = $request->route('slider');
        $slider = slider::findOrFail($id);
        $data = $request->all();
        $actifCover = Slider::where("is_cover", 1)->first();
        //dd($data);

        if (isset($data['image'])) {
            deleteImage($slider->image);
            $data['image'] = ImageUploadHelper::upload(rand(1, 9000), $this->uploadPath, $data['image']);
        }

        if ($data["status"] == 0 && $data["is_cover"] == 1) {
            $data["status"] = true;
        }

        if ($data["is_cover"] == 1 && $actifCover != null) {
            $actifCover->update(["is_cover" => false]);
        }

        $update = $slider->update($data);


        if ($update) {
            return redirect()->back()->with('success', 'Slider başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Slider güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function insertPicture(Request $request)
    {
        $all = $request->except("_token");
        return response()->json(["success" => "ok"]);
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        deleteImage($slider->image);

        $delete = $slider->delete();
        $result = [];

        if ($delete) {
            $result["success"] = "Slider başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Yönetici başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Slider silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
