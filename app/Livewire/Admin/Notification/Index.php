<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\ProductWarehouse;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $low_quantity_products;

    public $how_many = 5;

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->low_quantity_products = ProductWarehouse::select('product_id', 'qty', 'stock_alert')
            ->whereColumn('qty', '<=', 'stock_alert')
            ->take($this->how_many)
            ->get();
    }

    public function loadMore(): void
    {
        $this->how_many += 5;
        $this->mount();
    }

    public function markAsRead($key): void
    {
        $notification = $this->user->unreadNotifications[$key];
        $notification->markAsRead();
    }

    public function readAll(): void
    {
        // mark all notifications as read
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
    }

    public function clear(): void
    {
        // clear all notifications
        $user = auth()->user();
        $user->notifications()->delete();
    }


    public function render()
    {
        return view('livewire.admin.notification.index');
    }
}
