<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions for guard sanctum and web
        Permission::create(['guard_name' => 'web', 'name' => 'create users']);
        Permission::create(['guard_name' => 'web', 'name' => 'read users']);
        Permission::create(['guard_name' => 'web', 'name' => 'update users']);
        Permission::create(['guard_name' => 'web', 'name' => 'delete users']);

        Permission::create(['guard_name' => 'web', 'name' => 'create roles']);
        Permission::create(['guard_name' => 'web', 'name' => 'read roles']);
        Permission::create(['guard_name' => 'web', 'name' => 'update roles']);
        Permission::create(['guard_name' => 'web', 'name' => 'delete roles']);

        Permission::create(['guard_name' => 'web', 'name' => 'create shops']);
        Permission::create(['guard_name' => 'web', 'name' => 'read shops']);
        Permission::create(['guard_name' => 'web', 'name' => 'update shops']);
        Permission::create(['guard_name' => 'web', 'name' => 'delete shops']);

        Permission::create(['guard_name' => 'sanctum', 'name' => 'create users']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'read users']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'update users']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'delete users']);

        Permission::create(['guard_name' => 'sanctum', 'name' => 'create roles']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'read roles']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'update roles']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'delete roles']);

        Permission::create(['guard_name' => 'sanctum', 'name' => 'create shops']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'read shops']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'update shops']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'delete shops']);


        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'super-admin']);
        $role1->givePermissionTo('create users'); // users
        $role1->givePermissionTo('read users');
        $role1->givePermissionTo('update users');
        $role1->givePermissionTo('delete users');
        $role1->givePermissionTo('create roles'); // roles
        $role1->givePermissionTo('read roles');
        $role1->givePermissionTo('update roles');
        $role1->givePermissionTo('delete roles');
        $role1->givePermissionTo('read shops'); // shops
        $role1->givePermissionTo('delete shops');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('create users'); // users
        $role2->givePermissionTo('read users');
        $role2->givePermissionTo('update users'); // update own account
        $role2->givePermissionTo('delete users'); // delete own account

        $role3 = Role::create(['name' => 'seller']);
        $role3->givePermissionTo('read users'); // users
        $role3->givePermissionTo('update users'); // update own account
        $role3->givePermissionTo('delete users'); // delete own account
        $role3->givePermissionTo('create shops'); //shops
        $role3->givePermissionTo('read shops'); // read own shop
        $role3->givePermissionTo('update shops'); // update own shop
        $role3->givePermissionTo('delete shops'); // delete own shop

        $role4 = Role::create(['name' => 'user']);
        $role4->givePermissionTo('read users');
        $role4->givePermissionTo('update users'); // update own account
        $role4->givePermissionTo('delete users'); // delete own account
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@app.test',
            'phone' => '085814316629',
            'address' => json_encode(['jalan' => 'Ampera Raya', 'rt' => '01', 'rw' => '01', 'no' => '45', 'kecamatan' => 'Cilandak Timur', 'kelurahan' => 'Pasar Minggu', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta', 'kodepos' => '12560'])
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@app.test',
            'phone' => '085814316629',
            'address' => json_encode(['jalan' => 'Ampera Raya', 'rt' => '01', 'rw' => '01', 'no' => '45', 'kecamatan' => 'Cilandak Timur', 'kelurahan' => 'Pasar Minggu', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta', 'kodepos' => '12560'])
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Seller',
            'email' => 'seller@app.test',
            'phone' => '085814316629',
            'address' => json_encode(['jalan' => 'Ampera Raya', 'rt' => '01', 'rw' => '01', 'no' => '45', 'kecamatan' => 'Cilandak Timur', 'kelurahan' => 'Pasar Minggu', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta', 'kodepos' => '12560'])
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@app.test',
            'phone' => '085814316629',
            'address' => json_encode(['jalan' => 'Ampera Raya', 'rt' => '01', 'rw' => '01', 'no' => '45', 'kecamatan' => 'Cilandak Timur', 'kelurahan' => 'Pasar Minggu', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta', 'kodepos' => '12560'])
        ]);
        $user->assignRole($role4);
    }
}
