<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount;

    public $listeners = [
        'cartCountUpdated',
    ];

    public function mount()
    {
        $this->cartCount = Cart::instance('shopping')->count();
    }

    public function cartCountUpdated()
    {
        $this->cartCount = Cart::instance('shopping')->count();
        $this->dispatch('cartBarUpdated');
    }

    public function render(): View|Factory
    {
        return view('livewire.front.cart-count');
    }
}
