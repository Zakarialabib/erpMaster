<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create([
            'name'       => 'customer',
            'guard_name' => 'customer',
        ]);

        // $role1->givePermissionTo('customer access');

        $customer = \App\Models\Customer::factory()->create([
            'id'       => Str::uuid(),
            'name'     => 'Client',
            'email'    => 'client@mail.com',
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole($role1);

        $role2 = Role::create([
            'name'       => 'vendor',
            'guard_name' => 'customer',
        ]);

        $customer1 = \App\Models\Customer::factory()->create([
            'id'       => Str::uuid(),
            'name'     => 'Vendor',
            'email'    => 'vendor@mail.com',
            'password' => bcrypt('password'),
        ]);
        $customer1->assignRole($role2);
    }
}
