<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductWarehouse;
use Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $product = Product::create([
                'name'        => $row['name'],
                'description' => $row['description'] ?? null,
                'slug'        => Str::slug($row['name']),
                'price'       => $row['price'],
                'old_price'   => $row['cost'] ?? null,
                'code'        => $row['code'] ?? Str::random(10),
                'category_id' => Category::where('name', $row['category'])->first()->id ?? Category::create(['name' => $row['category'],'slug' => Str::slug($row['category'])])->id ?? null,
                'brand_id'    => Brand::where('name', $row['brand'])->first()->id ?? Brand::create(['name' => $row['brand']])->id ?? null,
                // 'image'       => Helpers::uploadImage($row['image'], $row['name']) ?? 'default.jpg',
                'status'            => 0,
                'barcode_symbology' => 'c128',
                'unit'              => 'pc',
                'order_tax'         => 0,
                'tax_type'          => 0,
                'embeded_video'     => $row['embeded_video'],
                'subcategories'     => json_encode($row['subcategories']),
                'meta_title'     => Str::limit($row['name']),
                'meta_description' => Str::limit($row['description']) ?? null,
            ]);

            $productWarehouseData = explode(',', $row['productwarehouse']);

            foreach ($productWarehouseData as $warehouseData) {
                $warehouseName = $warehouseData;
                $price = $row['price'] * 100;
                $cost = $row['cost'] * 100;

                $productWarehouse = ProductWarehouse::create([
                    'product_id'   => $product->id,
                    'warehouse_id' => Warehouse::where('name', $warehouseName)->first()->id ?? Warehouse::create(['name' => $warehouseName])->id ?? null,
                    'qty'        => 0,
                    'stock_alert'        => 0,
                    'price'        => $price,
                    'cost'         => $cost,
                ]);
            }
        }
    }
}