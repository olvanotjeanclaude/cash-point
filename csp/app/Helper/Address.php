<?php

namespace App\Helper;

use Illuminate\Support\Str;
use App\Models\District;
use App\Models\Province;
use App\Models\Neighborhood;

trait Address
{
    public function get_province()
    {
        return $this->hasOne(Province::class, "province_key", "province");
    }

    public function get_district()
    {
        return $this->hasOne(District::class, "district_key", "district");
    }

    public function get_neighborhood()
    {
        return $this->hasOne(Neighborhood::class, "neighborhood_key", "neighborhood");
    }

    public function getFullAddressAttribute()
    {
        if(isset($this->get_neighborhood->neighborhood_name)){

          $neighborhood = Str::lower($this->get_neighborhood->neighborhood_name);
          $neighborhood = ucwords($neighborhood);
          $district = $this->get_district->district_name;
          $province = $this->get_province->province_name;
          $fullAddress = "$neighborhood Mahalessi, $district/$province";
          return ($fullAddress);
        }
    }
}
