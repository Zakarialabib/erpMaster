<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CartBar extends Component
{
    use LivewireAlert;

    public $showCart = false;

    public $productId;

    public $listeners = [
        'showCart',
        'hideCart',
        'confirmed',
    ];

    public $shipping;

    public $shipping_id;

    public function confirmed(): void
    {
        Cart::instance('shopping')->remove($this->productId);
        $this->dispatch('cartCountUpdated');
        $this->cartBarUpdated();
    }

    public function showCart(): void
    {
        $this->showCart = true;
    }

    public function decreaseQuantity($rowId): void
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $qty = $cartItem->qty - 1;
        Cart::instance('shopping')->update($rowId, $qty);
        $this->cartBarUpdated();
    }

    public function increaseQuantity($rowId): void
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $qty = $cartItem->qty + 1;
        Cart::instance('shopping')->update($rowId, $qty);
        $this->cartBarUpdated();
    }

    public function removeFromCart($rowId): void
    {
        $this->productId = $rowId;

        $this->confirm(
            __('Remove from cart ?'),
            [
                'position'          => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'confirm',
                'onConfirmed'       => 'confirmed',
                'showCancelButton'  => true,
                'cancelButtonText'  => 'cancel',
            ]
        );
    }

    #[On('cartBarUpdated')]
    public function cartBarUpdated(): void
    {
        $this->cartTotal();
        $this->cartItems();
    }

    #[Computed]
    public function cartItems()
    {
        return Cart::instance('shopping')->content();
    }

    #[Computed]
    public function cartTotal()
    {
        return Cart::instance('shopping')->total();
    }

    public function render(): View|Factory
    {
        return view('livewire.front.cart-bar');
    }
}
