<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Transaction::create([
        //     'trx_id' => date('Ymdhis') . Str::random(4),
        //     'shop_id' => Shop::where('user_id', 2)->first()->id,
        //     'product_id' => 1,
        //     'user_id' => 4,
        //     'method_id' => 1,
        //     'qty' => 1,
        //     'custom_price' => 0,
        //     'status' => 'waiting',
        // ]);
        // Transaction::create([
        //     'trx_id' => date('Ymdhis') . Str::random(4),
        //     'shop_id' => Shop::where('user_id', 2)->first()->id,
        //     'product_id' => 2,
        //     'user_id' => 4,
        //     'method_id' => 1,
        //     'qty' => 1,
        //     'custom_price' => 0,
        //     'status' => 'waiting',
        // ]);
        // Transaction::create([
        //     'trx_id' => date('Ymdhis') . Str::random(4),
        //     'shop_id' => Shop::where('user_id', 4)->first()->id,
        //     'product_id' => 3,
        //     'user_id' => 4,
        //     'method_id' => 1,
        //     'qty' => 1,
        //     'custom_price' => 0,
        //     'status' => 'waiting',
        // ]);
    }
}
