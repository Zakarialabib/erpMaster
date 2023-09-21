<?php

declare(strict_types=1);

namespace App\Enums;

enum TaxType: int
{
    case INCLUSIVE = 0;

    case EXCLUSIVE = 1;

    public function label(): string
    {
        return match ($this) {
            static::INCLUSIVE => __('Inclusive'),
            static::EXCLUSIVE => __('Exclusive'),
        };
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function getLabel($value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->getValue() === $value) {
                return $case->label();
            }
        }

        return null;
    }
}
