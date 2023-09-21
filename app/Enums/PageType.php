<?php

declare(strict_types=1);

namespace App\Enums;

enum PageType: string
{
    case HOME = 'home';
    case ABOUT = 'about';
    case BLOG = 'blog';
    case SERVICE = 'service';
    case PRODUCT = 'product';
    case FAQ = 'faq';
    case TEAM = 'team';
    case CONTACT = 'contact';

    public function label(): string
    {
        return match ($this) {
            static::HOME    => __('Home'),
            static::ABOUT   => __('About'),
            static::BLOG    => __('Blog'),
            static::CONTACT => __('Contact'),
            static::SERVICE => __('Service'),
            static::PRODUCT => __('Product'),
            static::FAQ     => __('Faq'),
            static::TEAM    => __('Team'),
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function options(): array
    {
        return self::cases();
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
