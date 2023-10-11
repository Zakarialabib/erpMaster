<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use App\Models\ProductWarehouse;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Notifications extends Component
{
    use WithPagination;

    public $low_quantity_products;

    public $how_many = 5;

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    #[Computed]
    public function lowQuantity()
    {
       return ProductWarehouse::select('product_id', 'qty', 'stock_alert')
        ->whereColumn('qty', '<=', 'stock_alert')
        ->take($this->how_many)
        ->get();
    }

    public function loadMore(): void
    {
        $this->how_many += 5;
        $this->lowQuantity();
    }

    public function markAsRead($key): void
    {
        $notification = $this->user->unreadNotifications[$key];
        $notification->markAsRead();
    }

    public function readAll(): void
    {
        $this->user->unreadNotifications->markAsRead();
    }

    public function clear(): void
    {
        // clear all notifications
        $this->user->notifications()->delete();
    }

    public function render()
    {
        return view('livewire.utils.notifications');
    }
}
