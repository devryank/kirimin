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
