<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'name' => 'kg'
        ]);
        Unit::create([
            'name' => 'liter'
        ]);
        Unit::create([
            'name' => 'piece'
        ]);
        Unit::create([
            'name' => 'ikat'
        ]);
        Unit::create([
            'name' => 'unit'
        ]);
        Unit::create([
            'name' => 'piring'
        ]);
        Unit::create([
            'name' => 'gelas'
        ]);
    }
}
