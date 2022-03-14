<?php

namespace App\Http\Controllers\admin\contract;

use App\Helper\Message;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{

    public function index()
    {
        $contracts = Contract::has("project")->orderBy("id", "desc")->get();

        return view("admin.contract.index", compact("contracts"));
    }


    public function create()
    {
        $projects = Project::orderBy("id", "desc")->get();
        return view("admin.contract.create", compact("projects"));
    }


    public function store(Request $request)
    {
        $data = $request->except("_token");
        $data["user_id"] = Auth::user()->id;

        $saved = Contract::create($data);

        //dd($saved,Contract::count());

        if ($saved) {
            return redirect()->route("admin.contracts.index")->with('success', Message::SUCCESS);
        }

        return back()->with('error', Message::ERROR)->withInput();
    }


    public function show(Contract $contract)
    {
        return view("admin.contract.show", compact("contract"));
    }


    public function edit(Contract $contract)
    {
        $projects = Project::orderBy("id", "desc")->get();
        return view("admin.contract.edit", compact("contract", "projects"));
    }


    public function update(Request $request, $id)
    {
        $findUs = Contract::findOrFail($id);

        $update = $findUs->update($request->all());

        if ($update) {
            return redirect("admin/contracts")->with('success', 'Sözleşme Başarılı bir şekilde güncellendi.');
        }

        return back()->with('error', 'Güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id)
    {
        $findUs = Contract::findOrFail($id);

        $delete = $findUs->delete();

        $result = Message::getDeleteMessage($delete, "Sözleşme");

        return response()->json($result);
    }
}
