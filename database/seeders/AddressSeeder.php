<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // milih rt yang sama
        Address::create([
            'jalan' => 'Ampera Raya',
            'rt' => '01',
            'rw' => '01',
            'no' => '45',
            'kelurahan' => 'Cilandak Timur',
            'kecamatan' => 'Pasar Minggu',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'kodepos' => '12560',
        ]);

        // milih rw yang sama
        Address::create([
            'jalan' => 'Ampera Raya',
            'rt' => '03',
            'rw' => '01',
            'no' => '33',
            'kelurahan' => 'Cilandak Timur',
            'kecamatan' => 'Pasar Minggu',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'kodepos' => '12560',
        ]);

        // milih rw yang sama
        Address::create([
            'jalan' => 'Ampera Raya',
            'rt' => '04',
            'rw' => '01',
            'no' => '21',
            'kelurahan' => 'Cilandak Timur',
            'kecamatan' => 'Pasar Minggu',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'kodepos' => '12560',
        ]);

        // milih kelurahan yang sama
        Address::create([
            'jalan' => 'Ampera Raya',
            'rt' => '04',
            'rw' => '02',
            'no' => '45',
            'kelurahan' => 'Cilandak Timur',
            'kecamatan' => 'Pasar Minggu',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'kodepos' => '12560',
        ]);
    }
}
