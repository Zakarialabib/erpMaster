<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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

    // public $warehouseData;

    public function decreaseQuantity(): void
    {
        --$this->quantity;
    }

    public function increaseQuantity(): void
    {
        ++$this->quantity;
    }

    public function AddToCart($id, $price): void
    {
        $product = Product::where('id', $id)->first();
        // Cart::instance('shopping')->add($id, $this->quantity)->associate(Product::class);

        Cart::instance('shopping')->add(
            $product->id,
            $product->name,
            $this->quantity,
            $price,
        )->associate(Product::class);

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

    public function mount($slug): void
    {
        $this->product = Product::ecommerceProducts()->whereSlug($slug)->firstOrFail();
        // $this->warehouseData = $this->product->warehouses();
        $this->relatedProducts = Product::ecommerceProducts()
            ->active()
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
