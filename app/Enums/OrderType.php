<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderType: int
{
    case PRODUCT = 0;
    case SERVICE = 1;

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match ($this) {
            static::PRODUCT => __('Product'),
            static::SERVICE => __('Service'),
        };
    }

    public function getValue(): int
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
