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
            static::BLOG    => __('blog'),
            static::CONTACT => __('contact'),
            static::PRODUCT => __('product'),
            static::SERVICE => __('service'),
            static::FAQ     => __('faq'),
            static::TEAM    => __('team'),
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

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    // loop through the values:

    // @foreach(App\Enums\PageType::values() as $key=>$value)
    //     <option value="{{ $key }}">{{ $value }}</option>
    // @endforeach
}
