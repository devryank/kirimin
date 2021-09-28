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
            'user_id' => 3,
            'address_id' => 1,
            'name' => 'Warung Saya',
            'photo' => 'warung.jpg'
        ]);
    }
}
