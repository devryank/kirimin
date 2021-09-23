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
            'rt' => '01',
            'rw' => '01',
            'kelurahan' => 'Cilandak Timur',
            'kecamatan' => 'Pasar Minggu',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
        ]);
    }
}
