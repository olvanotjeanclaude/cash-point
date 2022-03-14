<?php

namespace App\Http\Controllers\admin\customer;

use App\Models\Bid;
use App\Models\FindUs;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helper\ImageUploadHelper;
use App\Models\CustomerOtherInfo;
use App\Http\Controllers\Controller;
use App\Models\CustomerMotif;
use App\Models\Meeting;
use App\Models\Motif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    public function index()
    {
        $customers =  Customer::orderBy("id", "desc")->get();
        return view("admin.customer.index", compact("customers"));
    }

    public function create()
    {
        $projects = Project::orderBy("id", "desc")->get();
        $foundUs = FindUs::orderBy("name")->get();
        return view("admin.customer.create", ['projects' => $projects, "foundUs" => $foundUs]);
    }


    public function store(Request $request)
    {
        $data = $request->except("_token");
        $customerArray = Arr::except($data, "otherInfo");

        if (isset($request->email)) {
            if (in_array($data["email"], Customer::emails())) {
                return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.")->withInput();
            }
        }

        if (isset($request->phone)) {
            $phone = Customer::where('phone', $request->phone)->first();
            if (isset($phone)) {
                return back()->with("errorEmail", "Sistemde seçtiğiniz telefon mevcut.")->withInput();
            }
        }

        $customerArray["status"] = true;
        $customerArray["user_id"] = Auth::user()->id;
        $customerArray["created_date"] = Carbon::today();

        if (isset($customerArray["image"])) {
            $image = (isset($customerArray['image'])) ? ImageUploadHelper::upload(rand(1, 9000), "customers", $customerArray['image']) : "";
            $customerArray["image"] = $image;
        }

        $newCustomer = Customer::create($customerArray);

        if (isset($request->otherInfo)) {
            $this->insert_other_info($newCustomer, $request);
        }

        if ($newCustomer) {
            return redirect("/admin/customers/$newCustomer->id")
                ->with('success', 'Müsteri başarılı bir şekilde eklendi.');
        }

        return back()->with('error', 'Müsteri kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $provinces = Province::all();
        $findUsData = FindUs::orderBy("name")->get();
        return view("admin.customer.edit", compact("customer", "provinces", "findUsData"));
    }

    public function show($id)
    {
        $provinces = Province::all();
        $customer = Customer::findOrFail($id);
        $bids = Bid::where('customer_id', $id)->get();;

        $customerMeetings = $customer->meetings()
            ->orderBy("date_time", "desc")
            ->get()
            ->filter(function ($meeting) {
                return $meeting->date_time < now();
            });


        $customerNotes = $customer->notes()->orderBy("id", "desc")->get();
        $customerDocuments = $customer->documents()->orderBy("id", "desc")->get();
        $customerProjects = $customer->Projects()->pluck("name")->toArray();

        $nextMeetings = $customer->meetings()
            ->orderBy("date_time", "desc")
            ->get()
            ->filter(function ($meeting) {
                return $meeting->date_time > now();
            });

        $findUsData = FindUs::orderBy("name")->get();

        //dd($nextMeetings);

        return view('admin.customer.show', compact(
            'customer',
            "customerNotes",
            "customerDocuments",
            "customerMeetings",
            "provinces",
            "nextMeetings",
            "bids",
            "findUsData",
            "customerProjects"
        ));
    }


    public function update(Request $request)
    {
        $id = $request->route('customer');
        $customer = Customer::findOrFail($id);
        $allEmails = Customer::pluck("email")->toArray();

        $data = $request->except('_token');

        if ($customer->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

        if (isset($data['image'])) {
            deleteImage($customer->image);
            if ((Auth::user()->permission == 1) || (Auth::user()->permission == 2)) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']);
            } elseif (Auth::user()->permission == 3) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "customer", $data['image']);
            }
        }

        $data = Arr::except($data, ["find_us_id", "other_info_description"]);

        $update = $customer->update($data);

        $update =  CustomerOtherInfo::updateOrCreate(
            ["customer_id" => $customer->id],
            [
                "find_us_id" => $request->find_us_id,
                "description" => $request->other_info_description
            ]
        );

        if ($update) {
            return redirect()->route('admin.customers.show', ['customer' => $id])->with('success', 'Müsteri başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Müsteri güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id)
    {
        $user = Customer::findOrFail($id);
        deleteImage($user->image);

        $delete = $user->delete();
        $result = [];


        if ($delete) {
            $result["success"] = "Müsteri başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.users.index')->with('success', 'Müsteri başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Müsteri silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }

    private function insert_other_info($newCustomer, $request)
    {
        if ($request->otherInfo["find_us_id"]) {
            return  $newCustomer->other_info()->create($request->otherInfo);
        }

        return null;
    }

    private function update_other_info($customer_id, $request)
    {
        $customer = Customer::findOrFail($customer_id);

        $array = [
            "find_us_id" => $request["find_us_id"],
            "description" => $request["other_info_description"],
        ];

        $update =  CustomerOtherInfo::updateOrCreate(["customer_id" => $customer_id], $array);

        if ($update) {
            return back()->with('success', 'Müsteri başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Müsteri güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function my_customers(Request $request)
    {
        $customers = $request->user()->my_customers();
        //dd($customers);
        if ($request->user()->permission == 1 || $request->user()->permission == 2) {
            $staffIds = explode(",", $request->user()->consultants);
            $customers = Customer::whereIn("user_id", $staffIds);
        }

        if ($customers->count() > 0) {
            $customers = $customers->orderBy("created_at", "desc")->get();
        }

        return view("admin.customer.my-customer", compact("customers"));
    }

    public function update_customer_info($customer_id, Request $request)
    {
        $customer = Customer::findOrFail($customer_id);
        $data = $request->except('_token');
        $allEmails = Customer::pluck("email")->toArray();

        if (isset($data["email"]) && $customer->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

        if (isset($data['image'])) {
            deleteImage($customer->image);
            if ((Auth::user()->permission == 1) || (Auth::user()->permission == 2)) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']);
            } elseif (Auth::user()->permission == 3) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "customer", $data['image']);
            }
        }

        if ($request->get("action") == "other_info") {
            return $this->update_other_info($customer_id, $data);
        }

        $update = $customer->update($data);

        if ($update) {
            return redirect()->route('admin.customers.show', ['customer' => $customer_id])->with('success', 'Müsteri başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Müsteri güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function customerProjects(Request $request)
    {
        $customer = Customer::findorfail($request->customer_id);
        $save = $customer->Projects()->sync($request->projects);
        if ($save) {
            return back()->with('success', 'Müsteri başarılı bir şekilde güncellendi.');
        }
    }

    public function customerFilter(Request $request)
    {
        $projects = Project::with('customers')->findMany(($request->projects));
        $customers = Customer::orderBy("id", "desc")->get();

        if (count($projects) > 0) {
            $customers = $projects[0]->customers;
        }

        return view("admin.customer.filter", ['customers' => $customers]);
    }

    public function priceFilter(Request $request)
    {
        $bids = Bid::has("customer");

        if ($request->low) {
            $bids = $bids->where("price", ">=", $request->low);
        }

        if ($request->max) {
            $bids = $bids->where("price", "<=", $request->max);
        }

        $bids = $bids->orderBy("price")->get();

        //dd($request->post("low"));
        return view('admin.customer.bid', ['bids' => $bids]);
    }

    public function loadMeeting($id)
    {
        $customer = Customer::findOrFail($id);

        $meetings = $customer->meetings()->orderBy("date_time", "desc")->limit(5)->get();

        return view("admin/customer/ajax-response/meeting", compact("meetings"));
    }

    public function updateStatus($customer_id, Request $request)
    {
        $motif = Motif::find($request->motif);
        $customer = Customer::findOrFail($customer_id);

        if ($request->motif == "other") {
            $motif = Motif::create(["body" => $request->body]);
        }

        $data = [
            "status" => $request->status,
            "motif_id" => $request->status == 0 ? $motif->id : null
        ];

        $saved = $customer->update($data);

        if ($saved) {
            return back()->with('success', 'Başarılı bir şekilde güncellendi.');
        }

        return back()->with('error', 'Müsteri güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }
}
