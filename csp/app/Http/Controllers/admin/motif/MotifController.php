<?php

namespace App\Http\Controllers\admin\motif;

use App\Models\Motif;
use App\Helper\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MotifController extends Controller
{

    public function index()
    {
        $motifs = Motif::has("user")->orderBy("id", "desc")->get();
        return view("admin.motifs.index", compact("motifs"));
    }


    public function create()
    {
        return view("admin.findUs.create");
    }


    public function store(Request $request)
    {
        $data = $request->except("_token");
        $data["user_id"] = Auth::user()->id;

        $saved = Motif::create($data);

        if ($saved) {
            return redirect()->route("admin.motifs.index")->with('success', Message::SUCCESS);
        }

        return back()->with('error', Message::ERROR)->withInput();
    }


    public function show(Motif $motif)
    {
        return response()->json($motif->toArray());
    }


    public function edit(Motif $motif)
    {
        return view("admin.motifs.edit", compact("motif"));
    }


    public function update(Request $request, $id)
    {
        $findUs = Motif::findOrFail($id);

        $update = $findUs->update(["body" => $request->body]);

        if ($update) {
            return back()->with('success', 'Başarılı bir şekilde güncellendi.');
        }

        return back()->with('error', 'Güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id)
    {
        $findUs = Motif::findOrFail($id);

        $delete = $findUs->delete();

        $result = Message::getDeleteMessage($delete, "sebep");

        return response()->json($result);
    }
}
