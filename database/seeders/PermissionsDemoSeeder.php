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

        // create roles and assign existing permissions
        $role1 = Role::create([
            'name'       => 'client',
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
    }
}
