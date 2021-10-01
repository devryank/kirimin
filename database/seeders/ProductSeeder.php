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
            'shop_id' => Shop::take(1)->first()->id,
            'unit_id' => 1,
            'name' => 'Cabai',
            'price' => 96000,
            'stock' => 'ready',
            'photo' => 'cabai.png'
        ]);
        Product::create([
            'shop_id' => Shop::take(1)->first()->id,
            'unit_id' => 1,
            'name' => 'Wortel',
            'price' => 15000,
            'stock' => 'ready',
            'photo' => 'wortel.png'
        ]);
    }
}
