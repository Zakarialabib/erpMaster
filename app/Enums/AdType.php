<?php

declare(strict_types=1);

namespace App\Enums;

enum AdType: string
{
    case HOMEPAGE = 'homepage';

    case CATALOG = 'catalog';

    case NEWSLETTER = 'newsletter';

    case BANNER = 'banner';

    case POPUP = 'popup';

    case FOOTER = 'footer';

    case SIDEBAR = 'sidebar';

    case OTHER = 'other';

    case SOCIAL = 'social';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
