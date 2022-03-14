<?php

namespace App\Http\Controllers\admin\consultants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultants;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultants::all();
        return view('admin.consultants.index', compact('consultants'));
    }

    public function create()
    {
        return view('admin.consultants.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $array = [
            'user_id' => Auth::user()->id,
            'name' => $all['name'],
            'surname' => $all['surname'],
            'email' => $all['email'],
            'phone' => $all['phone'],
        ];

        $insert = Consultants::create($array);

        if ($insert) {
            return redirect('admin/consultants')->with('success', 'Müşteri temsilcisi başarılı bir şekilde eklendi. Yeni bir danışman ekleyebilirsiniz.');
        } else {
            return redirect()->back()->with('error', 'Müşteri temsilcisi kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
        }
    }

    public function edit($id)
    {
        $c = Consultants::where('id', $id)->count();

        if ($c != 0) {
            $data = Consultants::where('id', $id)->get();
            return view('admin.consultants.edit', ["data" => $data]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('consultant');
        $c = Consultants::where('id', $id)->count();

        if ($c != 0) {
            $all = $request->except("_token");

            $array = [
                'name' => $all['name'],
                'surname' => $all['surname'],
                'email' => $all['email'],
                'phone' => $all['phone']
            ];

            $update = Consultants::where('id', $id)->update($array);

            if ($update) {
                return redirect('admin/consultants')->with('success', 'Müşteri temsilcisi başarılı bir şekilde güncellendi.');
            } else {
                return redirect()->back()->with('error', 'Müşteri temsilcisi güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
            }
        } else {
            return abort(404);
        }
    }

    public function destroy($id)
    {
        $result = [];
        $consultant = Consultants::findOrFail($id);

        $delete = $consultant->delete();

        if ($delete) {
            $result["success"] = "Müşteri temsilcisi başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = 'Müşteri temsilcisi silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!';
        }

        return response()->json($result);
    }
}
