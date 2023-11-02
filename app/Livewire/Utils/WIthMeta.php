<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use Livewire\Attributes\Rule;

trait WithMeta
{
    #[Rule('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title = '';

    #[Rule('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description = '';

    // $this->meta_title = Str::limit($this->title, 75);
    // $this->meta_title = Str::limit($this->title, 175);
}
