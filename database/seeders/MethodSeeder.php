<?php

namespace Database\Seeders;

use App\Models\Method;
use Illuminate\Database\Seeder;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Method::create([
            'name' => 'COD',
        ]);
        Method::create([
            'name' => 'OVO',
        ]);
        Method::create([
            'name' => 'DANA',
        ]);
    }
}
