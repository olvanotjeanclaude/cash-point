<?php

namespace App\Http\Controllers\front;

use App\Advertissement\AdvertissementGateway;
use App\User;
use App\Promo;
use App\District;
use App\PromoLog;
use App\Province;
use App\PageFooter;
use App\Consultants;
use App\PageAboutUs;
use App\Neighborhood;
use App\NotesToStaff;
use App\Advertisement;
use App\Mail\ContactForm;
use App\AdvertisementImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CompanyAdvertisementMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class indexController extends Controller
{
  private $paginateNumber = 100;

  public function index(Request $request)
  {
    $data = Advertisement::where('status', 1)->limit($this->paginateNumber)->inRandomOrder()->get();
    $stand_out = Advertisement::where('status', 1)->where('stand_out', 1)->limit(8)->inRandomOrder()->get();
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    $promos = DB::select("select p.*,u.slug from promos p left join users u on p.company_id = u.id where p.status = 1 and p.location = 1");
    foreach ($promos as  $value) {
      $companyPromoID = $value->id;

      PromoLog::create([
        'promo_id' => $companyPromoID,
        'user_ip' => $request->getClientIp(true),
        'click_or_view' => 2, // 2->goruntuleme
        'date' => date('d-m-Y')
      ]);
    }

    $this->update_statistic($data, 2);

    return view('index', [
      'data' => $data,
      'data_image' => $data_image,
      'stand_out' => $stand_out,
      'promos' => $promos,
    ]);
  }

  public function consultant_contact()
  {
    return view('front.consultant_contact');
  }

  public function consultant_contact_store(Request $request)
  {
    $all = $request->except('_token');
    NotesToStaff::create($all);
  }

  /** Tek bir ilan ayrıntılarını getir */
  public function get_advertisement($slug, Request $request)
  {

    $data = Advertisement::where('slug', $slug)->exists();

    if (!$data) {
      return abort(404);
    }

    $data =  Advertisement::where('slug', $slug)->get();

    $id = $data[0]->id;

    $advertisement = Advertisement::find($id);

    $dataFacades =  $advertisement->apartment_facades()->pluck("apartment_facade")->toArray();

    foreach (explode(',', $data[0]['consultants_id']) as $value) {
      $consultants = Consultants::where('id', $value)->get();
      $advertisement_consultants[] = $consultants;
    }

    $data_image = AdvertisementImage::where('advertisement_id', $data[0]['id'])->get();

    $company_info = User::where('id', $data[0]['user_id'])->get();

    $company = User::find($company_info[0]["id"]);

    $company_other_advertisement = $company->advertissements()->inRandomOrder()->limit(3)->get();

    $popular_advertisement = Advertisement::where("id", "!=", $id)->inRandomOrder()->where('status', 1)->limit(3)->get();

    $all_image = AdvertisementImage::where('isCover', 1)->get();
    $rightPromo = Promo::where('status', 1)->where('location', 2)->get();

    $promos = DB::select("select p.*,u.slug from promos p left join users u on p.company_id = u.id where p.status = 1 and p.location = 2");

    foreach ($promos as $value) {
      $companyPromoID = $value->id;
      //yucel
      PromoLog::create([
        'promo_id' => $companyPromoID,
        'user_ip' => $request->getClientIp(true),
        'click_or_view' => 1, //2->goruntuleme
        'date' => date('d-m-Y'),
      ]);

    }

    $this->update_statistic($data, 1);

    $province = Province::where('province_key', $data[0]['province'])->get();
    $district = District::where('district_key', $data[0]['district'])->get();
    $neighborhood = Neighborhood::where('neighborhood_key', $data[0]['neighborhood'])->get();


    return view('front.get_advertisement', [
      'data' => $data,
      'data_image' => $data_image,
      'company_info' => $company_info,
      'advertisement_consultants' => $advertisement_consultants,
      'popular_advertisement' => $popular_advertisement,
      'all_image' => $all_image,
      'company_other_advertisement' => $company_other_advertisement,
      'rightPromo' => $rightPromo,
      'province' => $province,
      'district' => $district,
      'neighborhood' => $neighborhood,
      "dataFacades" => $dataFacades
    ]);
  }


  /** Tüm satılık ilanları getir */
  public function bringForSale()
  {
    $bringForSale = Advertisement::where('status', 1)->where('sale_or_rent', 1)->orderBy('id', 'DESC')->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    $this->update_statistic($bringForSale, 2);

    return view('front.bring_for_sale', ['bringForSale' => $bringForSale, 'data_image' => $data_image]);
  }

  /** Tüm kiralık ilanları getir */
  public function bringTheRentals()
  {
    $bringTheRentals = Advertisement::where('status', 1)->where('sale_or_rent', 2)->orderBy('id', 'DESC')->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    $this->update_statistic($bringTheRentals, 2);

    return view('front.bring_the_rentals', ['bringTheRentals' => $bringTheRentals, 'data_image' => $data_image]);
  }

  /** Tüm ilanları getir */
  public function allAdvertisement()
  {
    $advertisement = Advertisement::where('status', 1)->inRandomOrder()->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();
    $provinces = Province::all();
    $kurumsalLinks = PageFooter::where("title", 1)->orderBy("id", "desc")->get();
    $quickLinks = PageFooter::where("title", 2)->orderBy("id", "desc")->get();

    $this->update_statistic($advertisement, 2);

    return view('front.all_advertisement', [
      'advertisement' => $advertisement,
      'data_image' => $data_image,
      'provinces' => $provinces,
      "kurumsalLinks" => $kurumsalLinks,
      "quickLinks" => $quickLinks
    ]);
  }

  /** Satılık ilanlar arasında arama */
  public function autocompleteSelling(Request $request)
  {
    if ($request->get('query')) {
      $query = $request->get('query');

      $data = DB::select("select * from advertisements where status = 1 and sale_or_rent = 1 and 
(title like '%" . $query . "%' or province like '%" . $query . "%' or district like '%" . $query . "%' or neighborhood like '%" . $query . "%' or advert_no like '%" . $query . "%')");

      $output = '<ul class="dropdown-menu" style="display: block; width: 100%;">';

      foreach ($data as $row) {
        $output .= '<li class="selling-item border-bottom p-2">
                      <a href="' . route('front.get_advertisement', ['slug' => $row->slug]) . '">
                        ' . $row->title . '
                      </a>
                    </li>';
      }

      $output .= '</ul>';


      echo $output;
    }
  }

  /** Kiralık ilanlar arasında arama */
  public function autocompleteRenting(Request $request)
  {
    if ($request->get('query')) {
      $query = $request->get('query');

      $data = DB::select("select * from advertisements where status = 1 and sale_or_rent = 2 and 
(title like '%" . $query . "%' or province like '%" . $query . "%' or district like '%" . $query . "%' or neighborhood like '%" . $query . "%' or advert_no like '%" . $query . "%')");

      $output = '<ul class="dropdown-menu" style="display: block; width: 100%;">';

      foreach ($data as $row) {
        $output .= '<li class="renting-item border-bottom p-2">
                      <a href="' . route('front.get_advertisement', ['slug' => $row->slug]) . '">
                      ' . $row->title . '
                      </a>
                    </li>';
      }

      $output .= '</ul>';
      echo $output;
    }
  }

  /** Detaylı arama */
  public function search(Request $request)
  {
    $property_type = $request->get('property_type');
    $number_of_rooms = $request->get('number_of_rooms');
    $sale_or_rent = $request->get('sale_or_rent');
    $province_key = $request->get('province_key');
    $district_key = $request->get('district_key');
    $neighborhood_key = $request->get('neighborhood_key');

    $districts = [];
    $neighborhoods = [];

    $activeAdvertisement = Advertisement::where('status', 1);

    if ($property_type != "") {
      $activeAdvertisement = $activeAdvertisement->where('property_type', $property_type);
    }

    if ($number_of_rooms != "") {
      $activeAdvertisement = $activeAdvertisement->where('number_of_rooms', $number_of_rooms);
    }

    if ($sale_or_rent != "") {
      $activeAdvertisement = $activeAdvertisement->where('sale_or_rent', $sale_or_rent);
    }


    if ($province_key != "") {
      $activeAdvertisement = $activeAdvertisement->where('province', $province_key);
      $districts = District::where("district_province_key", $province_key)->get();
    }

    if ($district_key != "") {
      $activeAdvertisement = $activeAdvertisement->where('district', $district_key);
      $neighborhoods = Neighborhood::where("neighborhood_district_key", $district_key)->get();
    }

    if ($neighborhood_key != "") {
      $activeAdvertisement = $activeAdvertisement->where('neighborhood', $neighborhood_key);
    }

    $result = $activeAdvertisement->paginate($this->paginateNumber);
    $countResult = $activeAdvertisement->count();


    $data_image = AdvertisementImage::where('isCover', 1)->get();

    return view('front.search-result', [
      'result' => $result,
      'data_image' => $data_image,
      "districts" => $districts,
      "neighborhoods" => $neighborhoods,
      "province_key" => $province_key,
      "district_key" => $district_key,
      "neighborhood_key" => $neighborhood_key,
      "countResult" => $countResult
    ]);
  }

  /** Tek ilan için firmaya mesaj gönderme */
  public function setAdvertisementMessage(Request $request)
  {
    $ads_id = $request->route('ads_id');
    $comp_id = $request->route('comp_id');

    $all = $request->except('_token');
    $array = [
      'user_id' => $comp_id,
      'advertisement_id' => $ads_id,
      'name' => $all['name'],
      'surname' => $all['surname'],
      'phone' => $all['phone'],
      'email' => $all['email'],
      'text' => $all['text']
    ];

    $insert = CompanyAdvertisementMessage::create($array);

    if ($insert) {
      return redirect()->back()->with('success', 'Kısa süre içersinde sizinle iletişime geçilecektir.');
    } else {
      return redirect()->back()->with('error', 'Mesajınız iletilemedi. Daha sonra tekrar deneyiniz!');
    }
  }

  /** Firma detay sayfası */
  public function getCompanyInfo($slug, Request $request)
  {
    $data = User::where('slug', $slug)->get();
    $companyId = $data[0]['id'];
    $data_image = AdvertisementImage::where('isCover', 1)->get();
    $getAllAdvertisement = Advertisement::where('status', 1)->where('user_id', $companyId)->paginate(12);
    $bringForSale = Advertisement::where('status', 1)->where('user_id', $companyId)->where('sale_or_rent', 1)->paginate(12); // Satılık
    $bringForRentals = Advertisement::where('status', 1)->where('user_id', $companyId)->where('sale_or_rent', 2)->paginate(12); // Kiralık
    $allConsultants = Consultants::where('user_id', $companyId)->get();

    $currentCompanyPromo = Promo::where('company_id', $data[0]['id'])->where('status', 1)->get();

    $rightPromo = Promo::where('status', 1)->where('location', 2)->get();

    if (count($currentCompanyPromo) != 0) {
      PromoLog::create([
        'promo_id' => $currentCompanyPromo[0]['id'],
        'user_ip' => $request->getClientIp(true),
        'click_or_view' => 1, // tıklama
        'date' => date('d-m-Y')
      ]);
    }

    return view('front.get_company_info', [
      'data' => $data,
      'getAllAdvertisement' => $getAllAdvertisement,
      'data_image' => $data_image,
      'bringForSale' => $bringForSale,
      'bringForRentals' => $bringForRentals,
      'allConsultants' => $allConsultants,
      'rightPromo' => $rightPromo
    ]);
  }

  public function getDistrictList(Request $request)
  {
    $all = $request->except('_token');
    $province_key = $all['province_key'];

    $district_list = \Illuminate\Support\Facades\DB::table('districts')
      ->where('district_province_key', $province_key)
      ->pluck('district_name', 'district_key');

    return response()->json($district_list);
  }

  public function getNeighborhoodList(Request $request)
  {
    $all = $request->except('_token');
    $district_key = $all['district_key'];

    $neighborhood_list = DB::table('neighborhoods')
      ->where('neighborhood_district_key', $district_key)
      ->pluck('neighborhood_name', 'neighborhood_key');

    return response()->json($neighborhood_list);
  }

  public function getContact()
  {
    return view("front.contact");
  }

  public function submitContactForm(Request $request)
  {
    $all = $request->except("_token");
    $request->validate([
      "fullName" => "required",
      "email" => "required",
      "subject" => "required",
      "message" => "required",
    ]);
    Mail::send(new ContactForm($all));
    //return view("emails.contact",["form"=>$all]);
    return redirect("/front/iletisim")->with("success", "Mesaj başarılı şekilde gönderildi.");
  }

  public function aboutUs()
  {
    $data = PageAboutUs::first();
    $bgImage = "front_assets/image/bg-about-us.jpg";
    if ($data && file_exists($data->image)) {
      $bgImage = $data->image;
    }
    return view("front.about-us", [
      "data" => $data,
      "bgImage" => $bgImage
    ]);
  }

  public function getCustomPage($slug)
  {
    $page = PageFooter::where("slug", $slug)->firstOrFail();
    return view("front.custom-page", compact("page"));
  }

  public function login_company(Request $request)
  {
    $companyId = $request->route("companyId");
    if (Auth::check()) {
      if (Auth::user()->permission == 1 && $companyId) {
        $company = User::findOrFail($companyId);
        Auth::logout();
        Auth::loginUsingId($company->id);
      }
    }
    return redirect("/admin");
  }

  private function update_statistic($advertisements, $pageType)
  {
    $advertisement = new AdvertissementGateway($advertisements, $pageType);
    return $advertisement->monitoring();
  }
}
