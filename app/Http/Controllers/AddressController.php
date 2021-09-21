<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function city($province_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' . $province_id);
        return $response;
    }

    public function kecamatan($city_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=' . $city_id);
        return $response;
    }
}
