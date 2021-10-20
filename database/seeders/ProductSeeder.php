<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // WARUNG SAYUR
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 1,
            'name' => 'Cabai',
            'price' => 96000,
            'stock' => 'ready',
            'custom_price' => '1',
            'photo' => 'cabai.png'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 1,
            'name' => 'Wortel',
            'price' => 15000,
            'stock' => 'ready',
            'custom_price' => '1',
            'photo' => 'wortel.png'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 1,
            'name' => 'Kentang',
            'price' => 16000,
            'stock' => 'ready',
            'custom_price' => '1',
            'photo' => 'kentang.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 1,
            'name' => 'Kol',
            'price' => 4000,
            'stock' => 'ready',
            'custom_price' => '1',
            'photo' => 'kol.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 4,
            'name' => 'Sawi',
            'price' => 5000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'sawi.png'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 3)->first()->id,
            'unit_id' => 3,
            'name' => 'Masako Sapi',
            'price' => 500,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'masako-sapi.jpg'
        ]);

        // WARUNG SEMBAKO
        Product::create([
            'shop_id' => Shop::where('user_id', 5)->first()->id,
            'unit_id' => 2,
            'name' => 'Beras',
            'price' => 10000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'beras.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 5)->first()->id,
            'unit_id' => 5,
            'name' => 'Gas Elpiji 3kg',
            'price' => 22000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'elpiji.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 5)->first()->id,
            'unit_id' => 5,
            'name' => 'Pepsodent',
            'price' => 5000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'pepsodent.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 5)->first()->id,
            'unit_id' => 5,
            'name' => 'Sabun Lifebuoy',
            'price' => 3500,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'sabun.jpg'
        ]);

        // WARUNG ANGKRINGAN
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 3,
            'name' => 'Bakwan',
            'price' => 1000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'bakwan.jpeg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 3,
            'name' => 'Tempe Bacem',
            'price' => 1000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'tempe-bacem.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 6,
            'name' => 'Keong Pedas',
            'price' => 3000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'keong-pedas.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 6,
            'name' => 'Nasi Kucing',
            'price' => 3000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'NasiKucing.jpg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 7,
            'name' => 'Teh Panas',
            'price' => 3000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'teh.jpeg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 7,
            'name' => 'Wedang Jahe',
            'price' => 3500,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'wedang-jahe.jpeg'
        ]);
        Product::create([
            'shop_id' => Shop::where('user_id', 6)->first()->id,
            'unit_id' => 7,
            'name' => 'Wedang Susu',
            'price' => 3500,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'wedang-susu.jpg'
        ]);
    }
}
