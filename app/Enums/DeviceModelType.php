<?php

declare(strict_types=1);

namespace App\Enums;

enum DeviceModelType: string
{
    case SMARTPHONE = 'Smartphone';

    case SMARTWATCH = 'Smartwatch';

    case TABLET = 'Tablet';

    case LAPTOP = 'Laptop';

    case DESKTOP = 'Desktop';

    case HEADPHONE = 'Headphone';

    case EARPHONE = 'Earphone';

    case SPEAKER = 'Speaker';

    case CAMERA = 'Camera';

    case PRINTER = 'Printer';

    case PROJECTOR = 'Projector';

    case ACCESSORIES = 'Accessories';

    case OTHERS = 'Others';

    public function value(): string
    {
        return $this->value;
    }

    public static function getSelectOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value()] = $case->label();
        }

        return $options;
    }

    public function label(): string
    {
        return __(sprintf($this->value));
    }

    // usage
    // use App\Enums\DeviceModelType;
    //
    // $model = DeviceModelType::SMARTPHONE();
    // $model->value(); // 'Smartphone'
    // $model->label(); // 'Smartphone'
}
