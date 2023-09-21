<?php

declare(strict_types=1);

namespace App\Enums;

enum MovementType: int
{
    case SALE = 0;

    case PURCHASE = 1;

    case SALERETURN = 2;

    case PURCHASERETURN = 3;

    case SALETRANSFER = 4;

    case PURCHASETRANSFER = 5;

    public function label(): string
    {
        return match ($this) {
            static::SALE             => __('SALE'),
            static::PURCHASE         => __('PURCHASE'),
            static::SALERETURN       => __('SALERETURN'),
            static::PURCHASERETURN   => __('PURCHASERETURN'),
            static::SALETRANSFER     => __('SALETRANSFER'),
            static::PURCHASETRANSFER => __('PURCHASETRANSFER'),
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
