<?php

namespace App\Http\Controllers\admin\page;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $social_medias = SocialMedia::orderBy("name","asc")->get();
        $contact = Contact::first();
        return view("admin.contact.index", compact("social_medias", "contact"));
    }

    public function update_component(Request $request)
    {
        $all = $request->except("_token");
        $component = $request->route("component");

        switch ($component) {
            case 'domain':
                return $this->update_domain($all);
                break;
            case 'address':
                return $this->update_address($all);
                break;
            case 'telephone':
                return $this->update_telephone($all);
                break;
            case 'embeded_address':
                return $this->update_embeded_address($all);
                break;

            default:
                return abort(404);
                break;
        }
    }

    private function update_domain($request)
    {
        $data = [
            "domain" => $request["domain"]
        ];

        $result = $this->update_contact($data);

        if ($result) {
            return back()->with('success', 'Domain başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Domain kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    private function update_telephone($request)
    {
        $array = [
            "telephone" => $request["telephone"]
        ];

        $result = $this->update_contact($array);

        if ($result) {
            return back()->with('success', 'Telefon başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Telefon kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    private function update_address($request)
    {
        $array = [
            "provinces" => $request["provinces"],
            "districts" => $request["districts"],
            "neighborhoods" => $request["neighborhoods"],
            "full_address" => $request["full_address"],
        ];

        $result = $this->update_contact($array);

        if ($result) {
            return back()->with('success', 'Adres başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Adres kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    private function update_embeded_address($request)
    {
        $array = [
            "embeded_address" => $request["embeded_address"]
        ];

        $result = $this->update_contact($array);

        if ($result) {
            return back()->with('success', 'Embeded adres başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Embeded adres kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function update_social_media(Request $request)
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
            return back()->with('success', 'Sosyal medya başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Sosyal medya kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    private function update_contact($data = [])
    {
        $contact = Contact::first();
        $result = null;

        if ($contact && count($data) > 0) {
            $result = $contact->update($data);
        } else {
            $result = Contact::create($data);
        }

        return $result;
    }
}
