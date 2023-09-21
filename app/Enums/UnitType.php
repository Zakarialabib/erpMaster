<?php

declare(strict_types=1);

namespace App\Enums;

enum UnitType: string
{
    case KG = 'kg';

    case PIECE = 'pcs';

    case METRE = 'm';

    case GRAM = 'gr';

    public function label(): string
    {
        return match ($this) {
            static::KG    => __('Kilo'),
            static::PIECE => __('piece'),
            static::METRE => __('Metre'),
            static::GRAM  => __('Gram'),
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
