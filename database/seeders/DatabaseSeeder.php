<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsDemoSeeder::class,
            AddressSeeder::class,
            ShopSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
