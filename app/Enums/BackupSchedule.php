<?php

declare(strict_types=1);

namespace App\Enums;

enum BackupSchedule: int
{
    case DAILY = 0;

    case WEEKLY = 1;

    case MONTHLY = 2;

    public function label(): string
    {
        return match ($this) {
            static::DAILY   => __('Daily backup'),
            static::WEEKLY  => __('Weekly backup'),
            static::MONTHLY => __('Monthly backup'),
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
