<?php

namespace Database\Seeders;

use App\Models\Shop;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'id' => Uuid::uuid4()->getHex(),
            'user_id' => 2,
            'address_id' => 1,
            'name' => 'Warung Sayur',
            'photo' => 'warung.jpg'
        ]);
        Shop::create([
            'id' => Uuid::uuid4()->getHex(),
            'user_id' => 4,
            'address_id' => 2,
            'name' => 'Warung Sembako',
            'photo' => 'warung-sembako.jpg'
        ]);
        Shop::create([
            'id' => Uuid::uuid4()->getHex(),
            'user_id' => 5,
            'address_id' => 3,
            'name' => 'Warung Angkringan',
            'photo' => 'angkringan.jpg'
        ]);
        Shop::create([
            'id' => Uuid::uuid4()->getHex(),
            'user_id' => 6,
            'address_id' => 4,
            'name' => 'Toko Bangunan',
            'photo' => 'toko-bangunan.jpg'
        ]);
    }
}
