<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id'                   => Str::uuid(),
            'name'                 => 'Admin',
            'email'                => 'admin@mail.com',
            'password'             => bcrypt('password'),
            'avatar'               => 'avatar.png',
            'phone'                => '0123456789',
            'role_id'              => 1,
            'status'               => 1,
            'is_all_warehouses'    => 1,
            'default_client_id'    => 1, // 'id' => 1, 'name' => 'Walk-in Client'
            'default_warehouse_id' => 1, // 'id' => 1, 'name' => 'Main Warehouse'
            'remember_token'       => null,
            'created_at'           => now(),
        ]);

        $role = Role::create([
            'guard_name' => 'admin',
            'name'       => 'admin',
        ]);

        $role->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        $user->assignRole($role);
    }
}
