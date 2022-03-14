<?php

namespace App\Http\Controllers\api;

use App\Advertisement;
use App\Http\Controllers\Controller;
use App\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function change_advertisement_status(Request $request)
  {
    $all = $request->except('_token');

    $control = $all['control'];
    $currentDate = date('Y-m-d');
    

    if ($control == true) {
      Advertisement::where('last_date', '<', $currentDate)->update([
        'stand_out' => false,
        'last_date' => null
      ]);

      $allAdvertissements= Advertisement::where("status",true);

      if($allAdvertissements->count()>0){
        foreach($allAdvertissements as $advertissement){
          $created_at= $advertissement->created_at->toDateString();
          $disabledAt = date('Y-m-d', strtotime("+3 months", strtotime($created_at))); 
          if($currentDate==$disabledAt){
            $advertissement->update([
              "status" =>false,
            ]);
          }
        } 
      }

      Promo::where('finished_at', '<', $currentDate)->update([
        'status' => false,
        'finished_at' => null
      ]);
    }
  }
}
