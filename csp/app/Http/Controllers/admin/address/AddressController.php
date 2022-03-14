<?php

namespace App\Http\Controllers\admin\address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function getDistrictList(Request $request)
    {
        $all = $request->except('_token');
        $province_key = $all['province_key'];
       
        $district_list = DB::table('districts')
            ->where('district_province_key', $province_key)
            ->orderBy("district_name","asc")
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
}
