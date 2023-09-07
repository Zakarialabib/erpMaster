<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Artisan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Cache extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.utils.cache');
    }

    public function onClearCache(): void
    {
        Artisan::call('optimize:clear');

        $this->alert('success', __('All caches have been cleared!'));
    }
}
