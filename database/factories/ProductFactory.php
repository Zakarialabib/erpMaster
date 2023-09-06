<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductWarehouse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id'                => Str::uuid(),
            'name'              => $this->faker->name,
            'code'              => Str::random(5),
            'category_id'       => 1,
            'slug'              => Str::slug($this->faker->name),
            'unit'              => 'pcs',
            'description'       => $this->faker->sentence,
            'image'             => 'https://www.apple.com/v/iphone/home/ah/images/overview/compare/compare_iphone_12__f2x.png',
            'barcode_symbology' => 'C39',
            'order_tax'         => 0,
            'tax_type'          => 0,
            'featured'          => true,
            'meta_title'        => '',
            'meta_description'  => '',
            'best'              => true,
            'hot'               => true,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $warehouses = Warehouse::inRandomOrder()->limit(2)->get();

            foreach ($warehouses as $warehouse) {
                ProductWarehouse::create([
                    'product_id'    => $product->id,
                    'warehouse_id'  => $warehouse->id,
                    'qty'           => '100',
                    'cost'          => '5000',
                    'price'         => '10000',
                    'old_price'     => '0',
                    'is_ecommerce'  => true,
                    'stock_alert'   => '10',
                    'is_discount'   => true,
                    'discount_date' => '2021-10-10',
                ]);
            }
        });
    }
}
