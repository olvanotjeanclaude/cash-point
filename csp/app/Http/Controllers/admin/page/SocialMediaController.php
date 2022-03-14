<?php

namespace App\Http\Controllers\admin\page;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{

    public function index()
    {
        $social_medias = SocialMedia::all();
        
        return view("admin.social_media.index", compact("social_medias"));
    }


    public function store(Request $request)
    {
        $all = $request->except("_token");

        foreach ($all as $name => $data) {
            $insert = SocialMedia::updateOrcreate(
                [
                    "name" => $name,
                ],
                [
                    "link" => $data,
                    "status" => true,
                ]
            );
        }

        if ($insert) {
            return redirect()->route("admin.social-medias.index")->with('success', 'Sosyal medya başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Sosyal medya kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


}
