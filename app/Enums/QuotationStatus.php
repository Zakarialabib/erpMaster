<?php

declare(strict_types=1);

namespace App\Enums;

enum QuotationStatus: string
{
    case PENDING = 0;

    case SENT = 1;

    case ACCEPTED = 2;

    case EXPIRED = 3;

    case REJECTED = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match ($this) {
            static::PENDING  => __('Pending'),
            static::SENT     => __('Sent'),
            static::ACCEPTED => __('Accepted'),
            static::EXPIRED  => __('Expired'),
            static::REJECTED => __('Rejected'),
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
            self::PENDING  => 'warning',
            self::SENT     => 'info',
            self::ACCEPTED => 'success',
            self::EXPIRED  => 'danger',
            self::REJECTED => 'alert',
            default        => 'secondary',
        };
    }
}
