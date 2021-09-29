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
            'name' => 'Cabai',
            'stock' => 'ready',
            'photo' => 'cabai.png'
        ]);
        Product::create([
            'shop_id' => Shop::take(1)->first()->id,
            'name' => 'Wortel',
            'stock' => 'ready',
            'photo' => 'wortel.png'
        ]);
    }
}
