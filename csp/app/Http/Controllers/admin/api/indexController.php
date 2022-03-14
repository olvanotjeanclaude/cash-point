<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\PromoLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
  public function getAPI()
  {
    /*
    $allPromos = DB::table("promo_logs")
      ->select('promo_logs.id as plId', 'promo_logs.date', 'promo_logs.promo_id', 'promos.company_id')
      ->select('promo_logs.date', DB::raw('count(*) as total'))
      ->join('promos', 'promo_logs.promo_id', '=', 'promos.id')
      ->where('status', "=", 1)
      ->where('promos.company_id', Auth::user()->id)
      ->groupBy('promo_logs.date')
      ->get();
*/

    $allPromos = DB::table("promo_logs")
      ->select('promo_logs.id as plId', 'promo_logs.date', 'promo_logs.promo_id', 'promos.company_id')
      ->join('promos', 'promo_logs.promo_id', '=', 'promos.id')
      ->where('status', "=", 1)
      ->where('promos.company_id', Auth::user()->id)
      ->where('date', date('d-m-Y'))
      ->get();


    return response()->json([
      'allPromos' => $allPromos
    ]);
  }
}

