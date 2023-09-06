<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductWarehouse;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class ProductShow extends Component
{
    use LivewireAlert;

    public $product;

    public $relatedProducts;

    public $brand;

    public $category;

    public $quantity = 1;

    public $product_id;

    public $product_name;

    public $product_price;

    public $product_qty;

    public $brand_products;

    public $decreaseQuantity;

    public $increaseQuantity;

    // public $warehouseData;

    public function decreaseQuantity()
    {
        $this->quantity -= 1;
    }

    public function increaseQuantity()
    {
        $this->quantity += 1;
    }

    public function AddToCart($product_id)
    {
        $warehouse = ProductWarehouse::where('product_id', $product_id)->first();

        $cartItem = Cart::instance('shopping')->add(
            $product_id,
            $warehouse->product->name,
            $this->quantity,
            $warehouse->price
        )->associate('App\Models\Product');

        // $cartItem->save();

        $this->dispatch('cartCountUpdated');

        $this->alert(
            'success',
            __('Product added to cart successfully!'),
            [
                'position'          => 'center',
                'timer'             => 3000,
                'toast'             => true,
                'text'              => '',
                'confirmButtonText' => 'Ok',
                'cancelButtonText'  => 'Cancel',
                'showCancelButton'  => false,
                'showConfirmButton' => false,
            ]
        );
    }

    public function mount($slug)
    {
        $this->product = Product::whereSlug($slug)->firstOrFail();
        // $this->warehouseData = $this->product->warehouses();
        $this->brand_products = Product::active()->where('brand_id', $this->product->brand_id)->take(3)->get();
        $this->relatedProducts = Product::active()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $this->brand = Brand::where('id', $this->product->brand_id)->first();
        $this->category = Category::where('id', $this->product->category_id)->first();
    }

    public function render(): View|Factory
    {
        return view('livewire.front.product-show');
    }
}
