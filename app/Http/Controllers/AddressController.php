<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function province()
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
        return $response;
    }

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

    public function kelurahan($kecamatan_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' . $kecamatan_id);
        return $response;
    }

    public function province_detail($province_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $province_id);
        return $response;
    }

    public function city_detail($city_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $city_id);
        return $response;
    }

    public function kecamatan_detail($kecamatan_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $kecamatan_id);
        return $response;
    }

    public function kelurahan_detail($kelurahan_id)
    {
        $response = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $kelurahan_id);
        return $response;
    }
}
