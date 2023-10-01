<?php

declare(strict_types=1);

namespace App\Livewire\Utils\Admin;

use Livewire\Attributes\Rule;

trait WithMeta
{
    #[Rule('max:170', message: 'The meta title a max of 170 characters.')]
    #[Rule('min:60', message: 'The meta title field is and must a min of 60.')]
    public string $meta_title = '';

    #[Rule('max:170', message: 'The meta description a max of 170 characters.')]
    #[Rule('min:60', message: 'The meta description field is and must be min of 60 characters.')]
    public string $meta_description = '';

    // $this->meta_title = Str::limit($this->title, 75);
    // $this->meta_title = Str::limit($this->title, 175);
}
