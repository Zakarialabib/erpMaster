<?php

declare(strict_types=1);

namespace App\Enums;

enum PurchaseReturnStatus: int
{
    case PENDING = 0;

    case ORDERED = 1;

    case COMPLETED = 2;

    case RETURNED = 3;
    case SHIPPED = 4;
    case Shipped = 5;

    public function label(): string
    {
        return match ($this) {
            static::PENDING   => __('Pending'),
            static::ORDERED   => __('Order'),
            static::COMPLETED => __('Completed'),
            static::SHIPPED   => __('Shipped'),
            static::RETURNED  => __('Returned'),
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

    public function getBadgeType(): string
    {
        return match ($this) {
            self::PENDING   => 'warning',
            self::RETURNED  => 'info',
            self::COMPLETED => 'success',
            default         => 'secondary',
        };
    }
}
