<?php

namespace App\Http\Controllers\admin\customer;

use App\Models\User;
use App\Models\Offers;
use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerOfferController extends Controller
{
    public function index($customerId, $meetingId)
    {
        $customer = User::findOrFail($customerId);
        $meeting = Meeting::findOrFail($meetingId);
        $offers = $meeting->offers()->where("customer_id", $customerId)->get();
        return view("admin.customer.offer.index", compact("meeting", "offers", "customer"));
    }

    public function create($customerId, $meetingId)
    {
        $customer = User::where("permission", 4)->where("id", $customerId)->firstOrFail();
        $meeting = Meeting::findOrFail($meetingId);
        return view("admin.customer.offer.create", compact("customer", "meeting"));
    }

    public function store(Request $request)
    {
        $customer_id = $request->route("customer_id");
        $meeting_id = $request->route("meeting_id");
        $data = $request->except("_token");

        $meeting = Meeting::findOrFail($meeting_id);

        $offers = isset($data["inner-group"]) ? $data["inner-group"] : [];
        $offers = $this->getOffersRequest($offers);

        $saved = false;

        if (count($offers) > 0 && $customer_id != null) {
            foreach ($offers as  $offer) {
                $meeting->offers()->create([
                    "content" => $offer,
                    "user_id" => Auth::user()->id,
                    "customer_id" => $customer_id,
                    "meeting_id" => $meeting_id
                ]);
                $saved = true;
            }
        }

        if ($saved) {
            return redirect("admin/customers/$customer_id/meeting/$meeting_id/offers")->with('success', 'Teklifler başarılı bir şekilde eklendi.');
        }

        return back()->with('error', 'Teklifler kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function show()
    {
        $offer_id = request()->route("offer_id");
        $customer_id = request()->route("customer_id");
        $offer = Offers::findOrFail($offer_id);
        $customer = $offer->customer;
        return view('admin.customer.modals.offer.edit', compact("offer", "customer"));
    }

    public function update(Request $request)
    {
        $id = $request->route("offer_id");
        $offer = Offers::findOrFail($id);

        if (is_null($request->content)) {
            return back()->with("error", "Lütfen teklifi girin!");
        }

        $updated = $offer->update(["content" => $request->content]);

        if ($updated) {
            return back()->with('success', 'Teklifler başarılı bir şekilde güncelledi.');
        }

        return back()->with('error', 'Teklifler kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function delete()
    {
        $id = request()->route("offer_id");
        $offer = Offers::findOrFail($id);

        $delete = $offer->delete();
        $result = [];

        if ($delete) {
            $result["success"] = "Teklfif başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "Teklfif silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }

    private function getOffersRequest(array $offers)
    {
        $result = [];
        if (count($offers) > 0) {
            foreach ($offers as $offer) {
                $result[] = $offer["offer"];
            }
        }
        return $result;
    }
}
