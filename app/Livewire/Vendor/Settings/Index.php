<?php

declare(strict_types=1);

namespace App\Livewire\Vendor\Settings;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.vendor.settings.index')->extends('layouts.vendor');
    }
}
