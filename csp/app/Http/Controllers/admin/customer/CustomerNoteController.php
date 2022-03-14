<?php

namespace App\Http\Controllers\admin\customer;

use App\Models\User;
use App\Models\CustomerNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerNoteController extends Controller
{
    public function index()
    {
        //
    }

    public function update(Request $request)
    {
        $all=$request->except("_token");

        if(is_null($all["content"])){
            return back()->with(["errorNote" =>"Lütfen boş not girmeyin!"]);
        }

        $customerNote = CustomerNote::findOrFail($request->route("note_id"));
      
        $updated= $customerNote->update(["content" => $all["content"]]);

        if ($updated) {
            return redirect("/admin/customers/$request->customer_id")
                ->with('success', 'Müsterinin notu başarılı bir şekilde güncellendi.');
        }

        return back()->with('error', 'Müsterinin notu güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function store(Request $request)
    {
        $all = $request->except("_token");
        $customer= Customer::findOrFail($request->customer_id);
        $customerNote = [
            "content" => $all["content"],
            "customer_id" => $request->customer_id,
            "added_user_id" => Auth::user()->id
        ];
        $insterted = $customer->notes()->create($customerNote);

        if ($insterted) {
            return redirect("/admin/customers/$request->customer_id")
                ->with('success', 'Müsterinin notu başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Müsterinin notu kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function show($customer_id, $note_id)
    {
        $customerNote = CustomerNote::findOrFail($note_id);
        return view("admin.customer.modals.note.edit-note",compact("customerNote","customer_id"));
    }

    
    public function delete($customer_id, $id)
    {
        
        $customerNote = CustomerNote::findOrFail($id);
       
        $delete = $customerNote->delete();
        $result = [];

        if ($delete) {
            $result["success"] = "Müsteri başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "Müsteri silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
