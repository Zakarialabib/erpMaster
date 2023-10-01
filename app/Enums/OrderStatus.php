<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = '0';

    case PROCESSING = '1';

    case COMPLETED = '2';

    case SHIPPED = '3';

    case RETURNED = '4';

    case CANCELED = '5';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match ($this) {
            static::PENDING   => __('Pending'),
            static::PROCESSING   => __('Processing'),
            static::COMPLETED => __('Completed'),
            static::SHIPPED   => __('Shipped'),
            static::RETURNED  => __('Returned'),
            static::CANCELED  => __('Canceled'),
        };
    }

    public function getBadgeType(): string
    {
        return match ($this) {
            self::PENDING   => 'warning',
            self::PROCESSING   => 'info',
            self::COMPLETED => 'success',
            self::SHIPPED   => 'primary',
            self::RETURNED  => 'alert',
            self::CANCELED  => 'danger',
            default         => 'secondary',
        };
    }

    // loop through the values:

    // @foreach(App\Enums\PaymentStatus::values() as $key=>$value)
    //     <option value="{{ $key }}">{{ $value }}</option>
    // @endforeach
}
