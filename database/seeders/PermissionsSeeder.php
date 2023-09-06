<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'section access',
        ]);

        Permission::create([
            'name' => 'section create',
        ]);

        Permission::create([
            'name' => 'section update',
        ]);

        Permission::create([
            'name' => 'section delete',
        ]);

        Permission::create([
            'name' => 'section show',
        ]);

        Permission::create([
            'name' => 'role access',
        ]);

        Permission::create([
            'name' => 'role create',
        ]);

        Permission::create([
            'name' => 'role update',
        ]);

        Permission::create([
            'name' => 'role delete',
        ]);

        Permission::create([
            'name' => 'role show',
        ]);

        Permission::create([
            'name' => 'shipping access',
        ]);
        Permission::create([
            'name' => 'shipping create',
        ]);
        Permission::create([
            'name' => 'shipping update',
        ]);
        Permission::create([
            'name' => 'shipping delete',
        ]);
        Permission::create([
            'name' => 'shipping show',
        ]);

        Permission::create([
            'name' => 'permission access',
        ]);

        Permission::create([
            'name' => 'permission create',
        ]);

        Permission::create([
            'name' => 'permission update',
        ]);

        Permission::create([
            'name' => 'permission delete',
        ]);

        Permission::create([
            'name' => 'permission show',
        ]);

        Permission::create([
            'name' => 'user show',
        ]);

        Permission::create([
            'name' => 'blog access',
        ]);

        Permission::create([
            'name' => 'blog create',
        ]);

        Permission::create([
            'name' => 'blog update',
        ]);

        Permission::create([
            'name' => 'blog delete',
        ]);

        Permission::create([
            'name' => 'blog show',
        ]);

        Permission::create([
            'name' => 'order access',
        ]);

        Permission::create([
            'name' => 'order create',
        ]);

        Permission::create([
            'name' => 'order update',
        ]);

        Permission::create([
            'name' => 'order delete',
        ]);

        Permission::create([
            'name' => 'order show',
        ]);

        Permission::create([
            'name' => 'subcategory access',
        ]);

        Permission::create([
            'name' => 'subcategory create',
        ]);

        Permission::create([
            'name' => 'subcategory update',
        ]);

        Permission::create([
            'name' => 'subcategory delete',
        ]);

        Permission::create([
            'name' => 'subcategory show',
        ]);

        Permission::create([
            'name' => 'setting access',
        ]);

        Permission::create([
            'name' => 'page access',
        ]);

        Permission::create([
            'name' => 'page settings',
        ]);

        Permission::create([
            'name' => 'category access',
        ]);

        Permission::create([
            'name' => 'category create',
        ]);

        Permission::create([
            'name' => 'category update',
        ]);

        Permission::create([
            'name' => 'category delete',
        ]);

        Permission::create([
            'name' => 'category show',
        ]);

        Permission::create([
            'name' => 'slider access',
        ]);

        Permission::create([
            'name' => 'slider create',
        ]);

        Permission::create([
            'name' => 'slider update',
        ]);

        Permission::create([
            'name' => 'slider delete',
        ]);

        Permission::create([
            'name' => 'slider show',
        ]);

        Permission::create([
            'name' => 'featuredbanner access',
        ]);

        Permission::create([
            'name' => 'featuredbanner create',
        ]);

        Permission::create([
            'name' => 'featuredbanner update',
        ]);

        Permission::create([
            'name' => 'featuredbanner delete',
        ]);

        Permission::create([
            'name' => 'featuredbanner show',
        ]);

        Permission::create([
            'name' => 'race show',
        ]);
        Permission::create([
            'name' => 'race access',
        ]);

        Permission::create([
            'name' => 'race create',
        ]);

        Permission::create([
            'name' => 'race edit',
        ]);

        Permission::create([
            'name' => 'race delete',
        ]);

        Permission::create([
            'name' => 'race import',
        ]);

        Permission::create([
            'name' => 'blogcategory access',
        ]);

        Permission::create([
            'name' => 'blogcategory create',
        ]);

        Permission::create([
            'name' => 'blogcategory update',
        ]);

        Permission::create([
            'name' => 'blogcategory delete',
        ]);

        Permission::create([
            'name' => 'blogcategory show',
        ]);

        Permission::create([
            'name' => 'currency access',
        ]);

        Permission::create([
            'name' => 'currency create',
        ]);

        Permission::create([
            'name' => 'currency update',
        ]);

        Permission::create([
            'name' => 'currency delete',
        ]);

        Permission::create([
            'name' => 'currency show',
        ]);

        Permission::create([
            'name' => 'email access',
        ]);

        Permission::create([
            'name' => 'email create',
        ]);

        Permission::create([
            'name' => 'email update',
        ]);

        Permission::create([
            'name' => 'email delete',
        ]);

        Permission::create([
            'name' => 'email show',
        ]);

        Permission::create([
            'name' => 'user access',
        ]);
        Permission::create([
            'name' => 'user create',
        ]);
        Permission::create([
            'name' => 'user update',
        ]);
        Permission::create([
            'name' => 'user delete',
        ]);

        Permission::create([
            'name' => 'customer access',
        ]);
        Permission::create([
            'name' => 'customer show',
        ]);
        Permission::create([
            'name' => 'customer create',
        ]);
        Permission::create([
            'name' => 'customer update',
        ]);
        Permission::create([
            'name' => 'customer delete',
        ]);
        Permission::create([
            'name' => 'product access',
        ]);
        Permission::create([
            'name' => 'product create',
        ]);
        Permission::create([
            'name' => 'product update',
        ]);
        Permission::create([
            'name' => 'product delete',
        ]);
        Permission::create([
            'name' => 'product show',
        ]);
        Permission::create([
            'name' => 'product import',
        ]);
        Permission::create([
            'name' => 'sale access',
        ]);
        Permission::create([
            'name' => 'sale create',
        ]);
        Permission::create([
            'name' => 'sale show',
        ]);
        Permission::create([
            'name' => 'sale update',
        ]);
        Permission::create([
            'name' => 'sale delete',
        ]);
        Permission::create([
            'name' => 'purchase access',
        ]);
        Permission::create([
            'name' => 'purchase create',
        ]);
        Permission::create([
            'name' => 'purchase update',
        ]);
        Permission::create([
            'name' => 'purchase delete',
        ]);
        Permission::create([
            'name' => 'report access',
        ]);
        Permission::create([
            'name' => 'show total stats',
        ]);
        Permission::create([
            'name' => 'dashboard access',
        ]);
        Permission::create([
            'name' => 'log access',
        ]);
        Permission::create([
            'name' => 'backup access',
        ]);

        Permission::create([
            'name' => 'brand access',
        ]);
        Permission::create([
            'name' => 'brand create',
        ]);
        Permission::create([
            'name' => 'brand update',
        ]);
        Permission::create([
            'name' => 'brand delete',
        ]);
        Permission::create([
            'name' => 'brand show',
        ]);
        Permission::create([
            'name' => 'brand import',
        ]);
        Permission::create([
            'name' => 'expense access',
        ]);
        Permission::create([
            'name' => 'expense show',
        ]);
        Permission::create([
            'name' => 'expense create',
        ]);
        Permission::create([
            'name' => 'expense update',
        ]);
        Permission::create([
            'name' => 'expense delete',
        ]);
        Permission::create([
            'name' => 'adjustment access',
        ]);
        Permission::create([
            'name' => 'adjustment create',
        ]);
        Permission::create([
            'name' => 'adjustment edit',
        ]);
        Permission::create([
            'name' => 'adjustment delete',
        ]);
        Permission::create([
            'name' => 'printer access',
        ]);
        Permission::create([
            'name' => 'printer create',
        ]);
        Permission::create([
            'name' => 'printer show',
        ]);
        Permission::create([
            'name' => 'printer edit',
        ]);
        Permission::create([
            'name' => 'printer delete',
        ]);
        Permission::create([
            'name' => 'quotation create',
        ]);
        Permission::create([
            'name' => 'quotation update',
        ]);
        Permission::create([
            'name' => 'quotation delete',
        ]);
        Permission::create([
            'name' => 'quotation sale',
        ]);
        Permission::create([
            'name' => 'print barcodes',
        ]);
        Permission::create([
            'name' => 'purchase return access',
        ]);
        Permission::create([
            'name' => 'purchase return create',
        ]);
        Permission::create([
            'name' => 'purchase return update',
        ]);
        Permission::create([
            'name' => 'purchase return show',
        ]);
        Permission::create([
            'name' => 'purchase return delete',
        ]);
        Permission::create([
            'name' => 'sale return access',
        ]);
        Permission::create([
            'name' => 'sale return create',
        ]);
        Permission::create([
            'name' => 'sale return update',
        ]);
        Permission::create([
            'name' => 'sale return show',
        ]);
        Permission::create([
            'name' => 'sale return delete',
        ]);

        Permission::create([
            'name' => 'expense categories access',
        ]);
        Permission::create([
            'name' => 'expense categories create',
        ]);
        Permission::create([
            'name' => 'expense categories show',
        ]);
        Permission::create([
            'name' => 'expense categories edit',
        ]);
        Permission::create([
            'name' => 'expense categories delete',
        ]);
        Permission::create([
            'name' => 'purchase payment access',
        ]);
        Permission::create([
            'name' => 'purchase payment create',
        ]);
        Permission::create([
            'name' => 'purchase payment update',
        ]);
        Permission::create([
            'name' => 'purchase payment delete',
        ]);
        Permission::create([
            'name' => 'quotation access',
        ]);
        Permission::create([
            'name' => 'supplier access',
        ]);
        Permission::create([
            'name' => 'supplier create',
        ]);
        Permission::create([
            'name' => 'supplier show',
        ]);
        Permission::create([
            'name' => 'supplier update',
        ]);
        Permission::create([
            'name' => 'supplier import',
        ]);
        Permission::create([
            'name' => 'supplier delete',
        ]);
        Permission::create([
            'name' => 'sale payment access',
        ]);
        Permission::create([
            'name' => 'sale payment create',
        ]);
        Permission::create([
            'name' => 'sale payment update',
        ]);
        Permission::create([
            'name' => 'sale payment delete',
        ]);
        Permission::create([
            'name' => 'warehouse access',
        ]);
        Permission::create([
            'name' => 'warehouse create',
        ]);
        Permission::create([
            'name' => 'warehouse show',
        ]);
        Permission::create([
            'name' => 'warehouse update',
        ]);
        Permission::create([
            'name' => 'warehouse delete',
        ]);
        Permission::create([
            'name' => 'language access',
        ]);
        Permission::create([
            'name' => 'language create',
        ]);
        Permission::create([
            'name' => 'language update',
        ]);
        Permission::create([
            'name' => 'language delete',
        ]);
    }
}
