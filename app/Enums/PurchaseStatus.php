<?php

declare(strict_types=1);

namespace App\Enums;

enum PurchaseStatus: int
{
    case PENDING = 0;

    case ORDERED = 1;

    case COMPLETED = 2;

    case RETURNED = 3;

    case CANCELED = 4;

    public function label(): string
    {
        return match ($this) {
            static::PENDING   => __('Pending'),
            static::ORDERED   => __('Order'),
            static::COMPLETED => __('Completed'),
            static::RETURNED  => __('Returned'),
            static::CANCELED  => __('Canceled'),
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

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function getBadgeType(): string
    {
        return match ($this) {
            self::PENDING   => 'warning',
            self::ORDERED   => 'primary',
            self::COMPLETED => 'success',
            self::RETURNED  => 'info',
            self::CANCELED  => 'danger',
            default         => 'dark',
        };
    }
}
