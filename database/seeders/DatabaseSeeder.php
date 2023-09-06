<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionsSeeder::class,
            SuperUserSeeder::class,
            // PermissionsDemoSeeder::class,
            CurrencySeeder::class,
            SettingsSeeder::class,
            LanguagesSeeder::class,
            MenuSeeder::class,
            SliderSeeder::class,
            BlogSeeder::class,
            SectionsSeeder::class,
            ShippingSeeder::class,
            // BrandSeeder::class,
            CategoriesSeeder::class,
            WarehouseSeeder::class,
            ProductsSeeder::class,
            ExpenseSeeder::class,
            CustomersSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
