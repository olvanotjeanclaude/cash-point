<?php

namespace App\Http\Controllers\admin\customer;

use Illuminate\Http\Request;
use App\Models\CustomerDocument;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerDocumentController extends Controller
{
    public function store($unique_id, Request $request)
    {
        $customer =  Customer::findOrFail($unique_id);
        $all = $request->except("_token");

        $arrayDoc = [
            "type" => $all["type"],
            'docTitle' => $all['title'],
            'client_id' => $customer->id,
            'user_id' => Auth::user()->id,
            'docFileUrl' => $this->uploadDoc($all["documentFile"]),
        ];

        $insertDoc = $customer->documents()->create($arrayDoc);

        if ($insertDoc) {
            return back()->with('success', 'Dosya başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Dosya kayıdı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function update(Request $request)
    {
        $all=$request->except("_token");

        if(is_null($all["type"])){
            return back()->with(["errorType" =>"Dokümanın tipi boş bırakılmaz!"]);
        }

        if(is_null($all["title"])){
            return back()->with(["errorTitle" =>"Dokümanın başlığı boş bırakılmaz!"]);
        }

        $customerNote = CustomerDocument::findOrFail($request->route("doc_id"));
        
        $arrayDoc = [
            "type" => $all["type"],
            'docTitle' => $all['title']
        ];
        
        if(isset($all["documentFile"])){
            deleteImage($customerNote->docFileUrl);
            $arrayDoc["docFileUrl"] = $this->uploadDoc($all["documentFile"]);
        }
       
        $updated = $customerNote->update($arrayDoc);

        if ($updated) {
            return redirect("/admin/customers/$request->customer_id")
                ->with('success', 'Müsterinin notu başarılı bir şekilde güncellendi.');
        }

        return back()->with('error', 'Müsterinin notu güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function download($customer_id,$file_id)
    {
        $document= CustomerDocument::findOrFail($file_id);
        return response()->download($document->docFileUrl);
    }



    public function show($customer_id, $note_id)
    {
        $customerDocument = CustomerDocument::findOrFail($note_id);
        return view("admin.customer.modals.document.edit-doc", compact("customerDocument","customer_id"));
    }


    public function delete($customer_id, $id)
    {
        $customerDocument = CustomerDocument::findOrFail($id);

        deleteImage($customerDocument->docFileUrl);
        $delete = $customerDocument->delete();
        $result = [];

        if ($delete) {
            $result["success"] = "Doküman başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "Doküman silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }

    private function uploadDoc($file)
    {
        if ($file) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = "uploads/customers/docs/";
            $file->move($path, $fileName);

            return "$path/$fileName";
        }

        return null;
    }
}
