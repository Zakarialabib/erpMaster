<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use App\Models\ProductWarehouse;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;

    public $low_quantity_products;
    public $how_many = 5;
    public $user;

    public function mount()
    {
        $this->user = auth()->user();

        $this->low_quantity_products = ProductWarehouse::select('product_id', 'qty', 'stock_alert')
            ->whereColumn('qty', '<=', 'stock_alert')
            ->take($this->how_many)
            ->get();
    }

    public function loadMore()
    {
        $this->how_many += 5;
        $this->mount();
    }

    public function markAsRead($key)
    {
        $notification = $this->user->unreadNotifications[$key];
        $notification->markAsRead();
    }

    public function readAll()
    {
        // mark all notifications as read
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
    }

    public function clear()
    {
        // clear all notifications
        $user = auth()->user();
        $user->notifications()->delete();
    }

    public function render()
    {
        return view('livewire.utils.notifications', [
            'low_quantity_products' => $this->low_quantity_products,
        ]);
    }
}
