<?php

namespace App\Http\Controllers\admin\bid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Floor;
use App\Models\Block;
use App\Models\BidStatus;
use App\Models\Bid;
use Auth;


class BidController extends Controller
{
  public function create_offer($id)
  {
    $apartment = Apartment::findorfail($id);
    $customers = Customer::get()->all();
    $bidStatuses = BidStatus::get()->all();

    return view('admin.bid.create', ['apartment' => $apartment, 'bidStatuses' => $bidStatuses, 'customers' => $customers]);
  }

  public function my_bids()
  {
    $bids = Bid::where('user_id', Auth::user()->id)->orderBy("created_at", "desc")->get();
    return view('admin.bid.my_bids', ['bids' => $bids]);
  }

  public function store(Request $request)
  {
    $data = $request->except("_token");

    $newBid = Bid::create($data);

    if ($newBid) {
      return redirect()->route('admin.apartments.view', ['id' => $request->apartment_id])->with('success', 'Teklif başarıyla eklendi..');
    }

    return redirect()->back()->with('error', 'Teklif kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
  }

  public function create()
  {
    $customers = Customer::get()->all();
    $bidStatuses = BidStatus::get()->all();
    $projects = Project::get()->all();
    $floors = Floor::get()->all();
    $blocks = Block::get()->all();
    $apartments = Apartment::get()->all();
    return view('admin.bid.createBlank', ['floors' => $floors, 'apartments' => $apartments, 'projects' => $projects, 'blocks' => $blocks, 'bidStatuses' => $bidStatuses, 'customers' => $customers]);
  }
}
