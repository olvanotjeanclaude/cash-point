<?php

namespace App\Http\Controllers\admin\sale;

use App\Models\Sale;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Block;
use App\Models\Project;
use App\Models\Floor;
use App\Models\Apartment;




class SaleController extends Controller
{
    public function index()
    {
        $sales =  Sale::get()->all();
        return view("admin.sale.index", compact("sales"));
    }

    public function get_project($id)
    {
        $blocks = Block::where('project_id', $id)->get();
        return response()->json($blocks);
    }

    public function get_floor($id)
    {
        $floors = Floor::where('block_id', $id)->get();
        return response()->json($floors);
    }

    public function get_apartments($id)
    {
        $apartments = Apartment::where('floor_id', $id)->get();
        return response()->json($apartments);
    }

    public function create()
    {
        $customers = Customer::get()->all();
        $projects = Project::get()->all();
        return view("admin.sale.create", ['customers' => $customers, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $request->except("_token");

        $newSale = Sale::create($data);

        if ($newSale) {
            return redirect()->route("admin.sales.index",)->with('success', 'Satış gerçekleştirildi.');
        }

        return redirect()->back()->with('error', 'Satış kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show(Sale $sale)
    {
        $apartment = $sale->apartment;
        $project = Project::first();
        $customer = $sale->customer;

        return view("admin.sale.show", compact("sale", "project", "apartment", "customer"));
    }

    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view("admin.floor.edit", compact("floor"));
    }

    public function update(Request $request)
    {
        $id = $request->route('floor');
        $floor = Floor::findOrFail($id);
        $data = $request->except('_token');
        $update = $floor->update($data);
        if ($update) {
            return back()->with('success', 'Kat başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Şübe güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $delete = $floor->delete();


        if ($delete) {
            $result["success"] = "Kat başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Kat silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
