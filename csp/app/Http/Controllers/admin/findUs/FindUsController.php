<?php

namespace App\Http\Controllers\admin\findUs;

use App\Helper\Message;
use App\Http\Controllers\Controller;
use App\Models\FindUs;
use Illuminate\Http\Request;

class FindUsController extends Controller
{
    public function index()
    {
        $findUs = FindUs::orderBy("id", "desc")->get();
        return view("admin.findUs.index", compact("findUs"));
    }


    public function create()
    {
        return view("admin.findUs.create");
    }


    public function store(Request $request)
    {
        $data = $request->except("_token");

        $saved = FindUs::create($data);

        if ($saved) {
            return redirect()->route("admin.find-us.index")->with('success', Message::SUCCESS);
        }

        return back()->with('error', Message::ERROR)->withInput();
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $findUs = FindUs::findOrFail($id);

        return view("admin.findUs.edit", compact("findUs"));
    }


    public function update(Request $request, $id)
    {
        $findUs = FindUs::findOrFail($id);

        $update = $findUs->update(["name" => $request->name]);

        if ($update) {
            return redirect()->route("admin.find-us.index")->with('success', 'Başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id)
    {
        $findUs = FindUs::findOrFail($id);

        $delete = $findUs->delete();

        $result = Message::getDeleteMessage($delete, "nereden bizi buldunuz");

        return response()->json($result);
    }
}
