<?php

declare(strict_types=1);

namespace App\Enums;

enum SaleReturnStatus: int
{
    case PENDING = 0;

    case ORDERED = 1;

    case COMPLETED = 2;

    case SHIPPED = 3;

    case RETURNED = 4;

    case CANCELED = 5;

    public function label(): string
    {
        return match ($this) {
            static::PENDING   => __('Pending'),
            static::ORDERED   => __('Order'),
            static::COMPLETED => __('Completed'),
            static::SHIPPED   => __('Shipped'),
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

    public function getBadgeType(): string
    {
        return match ($this) {
            self::PENDING   => 'warning',
            self::ORDERED   => 'info',
            self::COMPLETED => 'success',
            self::SHIPPED   => 'primary',
            self::RETURNED  => 'alert',
            self::CANCELED  => 'danger',
            default         => 'secondary',
        };
    }
}
