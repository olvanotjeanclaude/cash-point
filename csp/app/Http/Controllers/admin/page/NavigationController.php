<?php

namespace App\Http\Controllers\admin\page;

use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\Subscriber;

class NavigationController extends Controller
{
    public function index()
    {
        $data = Navigation::first();
        $subscribers = Subscriber::limit(10)->orderBy("id", "desc")->get();

        $navigation = $this->navigation();

        return view("admin.page.top-and-bottom", compact("navigation","subscribers"));
    }

    public function edit()
    {
        $navigation = $this->navigation();
        return view("admin.page.edit-top-and-bottom", compact("navigation"));
    }

    public function update(Request $request)
    {
        $all = $request->except("_token");
        $data = Navigation::first();
        $array = [];

        switch ($all["type"]) {
            case 'panel':
                $array = $this->get_panel_request($all, $data);
                break;
            case 'front':
                $array = $this->get_front_request($all, $data);
                break;
            case 'footerText':
                $array = $this->get_footer_text_request($all, $data);
                break;
        }

        if ($data) {
            $update = $data->update($array);
        } else {
            $update = Navigation::create($array);
        }

        if ($update) {
            return redirect()->route('admin.topBottom.index')->with('success', 'Personel başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Personel güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    private function get_panel_request($request, $data)
    {
        $array = [];
        if (isset($request['main_logo_panel'])) {
            if ($data) {
                deleteImage($data->main_logo_panel);
                $array['main_logo_panel'] = ImageUploadHelper::upload(rand(1, 9000), "backend/images", $request['main_logo_panel']);
            }
        }

        if (isset($request['favicon_panel'])) {
            if ($data) {
                deleteImage($data->favicon_panel);
                $array['favicon_panel'] = ImageUploadHelper::upload(rand(1, 9000), "backend/images", $request['favicon_panel']);
            }
        }

        $array["app_name"] = $request["app_name"];

        return $array;
    }


    private function get_front_request($request, $data)
    {
        $array = [];
        if (isset($request['main_logo_front'])) {
            if ($data) {
                deleteImage($data->main_logo_front);
                $array['main_logo_front'] = ImageUploadHelper::upload(rand(1, 9000), "backend/images", $request['main_logo_front']);
            }
        }

        if (isset($request['favicon_front'])) {
            if ($data) {
                deleteImage($data->favicon_front);
                $array['favicon_front'] = ImageUploadHelper::upload(rand(1, 9000), "backend/images", $request['favicon_front']);
            }
        }

        $array["front_name"] = $request["front_name"];

        return $array;
    }

    private function get_footer_text_request($request, $data)
    {
        $array = [];
        $array["bottom_text"] = $request["bottom_text"];

      
        if($data && isset($request["bg_footer"])){
            deleteImage($data->bg_footer);
            $array['bg_footer'] = ImageUploadHelper::upload(rand(1, 9000), "backend/images", $request['bg_footer']);
        }

        return $array;
    }

    private function navigation()
    {
        $data = Navigation::first();

        $navigation = [
            "app_name" =>  null,
            "main_logo_panel" => null,
            "favicon_panel" =>  null,
            "front_name" => null,
            "main_logo_front" => null,
            "favicon_front" => null,
            "bottom_text" =>  null,
            "bg_footer" =>  null,
        ];

        if ($data) {
            $navigation["app_name"] = $data->app_name;
            $navigation["main_logo_panel"] = $data->main_logo_panel;
            $navigation["favicon_panel"] = $data->favicon_panel;
            $navigation["front_name"] = $data->front_name;
            $navigation["main_logo_front"] = $data->main_logo_front;
            $navigation["favicon_front"] = $data->favicon_front;
            $navigation["bottom_text"] = $data->bottom_text;
            $navigation["bg_footer"] = $data->bg_footer;
        }

        return $navigation;
    }
}
