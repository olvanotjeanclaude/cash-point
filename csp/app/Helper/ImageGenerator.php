<?php

namespace App\Helper;

class ImageGenerator
{
    public function __construct()
    {
    }
    public static function generate()
    {
        $app_id="615ed4bb2777b83d0d63285c";
        $url="https://dummyapi.io/data/v1/post?limit=20";
        $headers= [
            "app-id" =>$app_id
        ];
        $curl= curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        $results = curl_exec($curl);
        curl_close($curl);

        return $results;
    }
}
