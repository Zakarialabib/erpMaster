<?php

declare(strict_types=1);

namespace App\Enums;

enum IntegrationType: int
{
    case CUSTOM = 0;

    case WOOCOMMERCE = 1;

    case SHOPIFY = 2;

    public function label(): string
    {
        return match ($this) {
            static::CUSTOM      => __('CUSTOM'),
            static::WOOCOMMERCE => __('WOOCOMMERCE'),
            static::SHOPIFY     => __('SHOPIFY'),
        };
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTypeName(): string
    {
        return match ($this->name) {
            IntegrationType::CUSTOM      => 'Custom',
            IntegrationType::WOOCOMMERCE => 'WooCommerce',
            IntegrationType::SHOPIFY     => 'Shopify',
            default                      => 'Unknown'
        };
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
