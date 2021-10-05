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
            'shop_id' => Shop::where('user_id', 5)->first()->id,
            'unit_id' => 2,
            'name' => 'Beras',
            'price' => 10000,
            'stock' => 'ready',
            'custom_price' => '0',
            'photo' => 'beras.png'
        ]);
    }
}
