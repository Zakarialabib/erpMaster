<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Str;

enum PageType: string
{
    case HOME = 'home';
    case ABOUT = 'about';
    case BLOG = 'blog';
    case SERVICE = 'service';
    case PACKAGE = 'package';
    case ACTIVITY = 'activity';
    case WORKSHOP = 'workshop`';
    case CONTACT = 'contact';

    public function getName(): string
    {
        return __(Str::studly($this->name));
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
                return $case->getName();
            }
        }

        return null;
    }
}
