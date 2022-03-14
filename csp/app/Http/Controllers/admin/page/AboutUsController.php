<?php

namespace App\Http\Controllers\admin\page;

use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $imagePath = "front/about_us";

    public function index()
    {
        $about_us = AboutUs::first();
        return view("admin.about_us.index", compact("about_us"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.about_us.create");
    }


    private function rules()
    {
        return [
            "title" => "required",
            "detail" => "required",
        ];
    }

    private function messages()
    {
        return [
            "title.required" => "Boş bırakılmaz.",
            "detail.required" => "Boş bırakılmaz",
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $about_us = AboutUs::first();

        return view("admin.about_us.edit", compact("about_us"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $all = $request->except("_token");

        $validator = Validator::make($all, $this->rules(), $this->messages());

        $validator->validate();

        $data = AboutUs::first();

        $array = [
            "title" => $all["title"],
            "detail" => $all["detail"],
            "user_id" => Auth::user()->id
        ];

        if ($data) {
            if (isset($all["image1"])) {
                deleteImage($data->image1);
                $array["image1"] = ($all["image1"] != null) ? ImageUploadHelper::upload("about-us-1", $this->imagePath, $all['image1']) : "";
            }

            if (isset($all["image2"])) {
                deleteImage($data && $data->image2);
                $array["image2"] = ($all["image2"] != null) ? ImageUploadHelper::upload("about-us-2", $this->imagePath, $all['image2']) : "";
            }
            $inserted = $data->update($array);
        } else {
            $inserted = AboutUs::create($array);
        }

        if ($inserted) {
            return redirect()->route("admin.about-us.index")->with('success', 'Bizim hakkında başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Bizim hakkında kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $footerLink = AboutUs::findOrFail($id);
        $deleted = $footerLink->delete();
        if ($deleted) {
            return redirect()->route("admin.page.footer.index")->with('success', 'Alt başlık başarılı bir şekilde silindi.');
        } else {
            return redirect()->back()->with('error', 'Alt başlık silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
        }
    }
}
