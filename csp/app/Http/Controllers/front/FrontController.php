<?php

namespace App\Http\Controllers\front;

use App\Models\User;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\District;
use App\Models\Province;
use App\Models\Consultants;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementImage;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
  private $paginateNumber = 100;


  public function index()
  {
    $sliders = Slider::where("status", 1)->orderBy("id", "desc")->get();
    $countCover = Slider::where("is_cover", 1)->whereNotNull("title")->count();
    $defaultCover = null;

    $data = Advertisement::where('status', 1)->limit($this->paginateNumber)->inRandomOrder()->get();
    $stand_out = Advertisement::where('status', 1)->where('stand_out', 1)->limit(8)->inRandomOrder()->get();
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    if ($countCover == 0) {
      $defaultCover = Slider::whereNotNull("title")->inRandomOrder()->first();
    }

    return view("index", compact("sliders", "defaultCover", "data", "stand_out", "data_image"));
  }

  public function getContact()
  {
    return view("front.contact");
  }

  public function aboutUs()
  {
    $about_us = AboutUs::first();
    return view("front.about-us", compact('about_us'));
  }

  /** Tek bir ilan ayrıntılarını getir */
  public function get_advertisement($slug, Request $request)
  {
    $data = Advertisement::where('slug', $slug)->firstOrFail();

    $id = $data->id;

    $advertisement = Advertisement::find($id);

    $dataFacades =  $advertisement->apartment_facades()->pluck("apartment_facade")->toArray();

    foreach (explode(',', $data->consultants_id) as $value) {
      $consultants = Consultants::where('id', $value)->get();
      $advertisement_consultants[] = $consultants;
    }

    $data_image = AdvertisementImage::where('advertisement_id', $id)->get();

    $user = $data->user;

    $user_other_advertisement = $user->advertissements()->inRandomOrder()->limit(3)->get();

    $popular_advertisement = Advertisement::where("id", "!=", $id)->inRandomOrder()->where('status', 1)->limit(3)->get();

    $all_image = AdvertisementImage::where('isCover', 1)->get();


    return view('front.get_advertisement', [
      'data' => $data,
      'data_image' => $data_image,
      'user' => $user,
      'advertisement_consultants' => $advertisement_consultants,
      'popular_advertisement' => $popular_advertisement,
      'all_image' => $all_image,
      'user_other_advertisement' => $user_other_advertisement,
      "dataFacades" => $dataFacades
    ]);
  }


  /** Tüm satılık ilanları getir */
  public function bringForSale()
  {
    $bringForSale = Advertisement::where('status', 1)->where('sale_or_rent', 1)->orderBy('id', 'DESC')->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    return view('front.bring_for_sale', ['bringForSale' => $bringForSale, 'data_image' => $data_image]);
  }

  /** Tüm kiralık ilanları getir */
  public function bringTheRentals()
  {
    $bringTheRentals = Advertisement::where('status', 1)->where('sale_or_rent', 2)->orderBy('id', 'DESC')->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();

    return view('front.bring_the_rentals', ['bringTheRentals' => $bringTheRentals, 'data_image' => $data_image]);
  }

  /** Tüm ilanları getir */
  public function allAdvertisement()
  {
    $all_advertisement = Advertisement::where('status', 1)->inRandomOrder()->paginate($this->paginateNumber);
    $data_image = AdvertisementImage::where('isCover', 1)->get();
    $provinces = Province::all();

    return view('front.all_advertisement', [
      'all_advertisement' => $all_advertisement,
      'data_image' => $data_image,
      'provinces' => $provinces
    ]);
  }
}
