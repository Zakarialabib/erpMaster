<?php

declare(strict_types=1);

namespace App\Exports;

trait ForModelsTrait
{
    public function forModels(mixed $selectedModels)
    {
        $this->models = $selectedModels;

        return $this;
    }
}
