<?php

namespace App\Http\Controllers\admin\branch;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;

class UserBranchController extends Controller
{

    private $permissions = [
        "admin" => 1,
        "manager" => 2,
        "staff" => 3,
        "customer" => 4
    ];

    private $user_permission;
    private $user = null;

    public function __construct(Request $request)
    {
        $this->user_permission = $this->get_user_type($request);
        $this->check_user($request);
        $this->user = User::findOrFail($request->id);
    }

    public function get_branch($user_type)
    {
        $user = $this->user;
        //$user->branchs()->sync([1,3]);
        $branchs = $user->branchs;

        return view("admin.$user_type.branchs", [
            $user_type => $user,
            "branchs" => $branchs
        ]);
    }

    public function create_branch($user_type,$id)
    {
        $branchs = Branch::orderBy("name", "asc")->get();
        $userBranchs= $this->user->branchs()->get();   
        $selectedBranchs=[];

        foreach ($userBranchs as $userBranch) {
            $selectedBranchs[] = $userBranch->id;
        }
        
        //dd($user_type);

        return view("admin.$user_type.add-branch", [
            $user_type => $this->user,
            "branchs" => $branchs,
            "selectedBranchs" =>$selectedBranchs
        ]);
    }

    public function edit_branch($id)
    {
    }

    public function sync_to_branch($user_type, $id, Request $request)
    {
        $all = $request->except("_token");
        $this->user->branchs()->sync($all["branch_id"]);
        
        return redirect("/admin/$user_type/$id/branchs")->with("success","Şübe başarılı bir şekilde eklendi.");
    }

    private function get_user_type($request)
    {
        if (!array_key_exists($request->user_type, $this->permissions)) {
            return abort(404);
        }

        return $this->permissions[$request->user_type];
    }

    private function check_user($request)
    {
        return  User::where("permission", $this->user_permission)->where("id", $request->id)->firstOrFail();
    }
}
