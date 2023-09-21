<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 0;

    case PAID = 1;

    case PARTIAL = 2;

    case DUE = 3;

    public function label(): string
    {
        return match ($this) {
            static::PENDING => __('Pending'),
            static::PAID    => __('Paid'),
            static::PARTIAL => __('Partial'),
            static::DUE     => __('Due'),
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
            self::PENDING => 'warning',
            self::PARTIAL => 'info',
            self::PAID    => 'success',
            default       => 'secondary',
        };
    }
}
