<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    final public const SALE_TYPE = 1;

    final public const POS_TYPE = 2;

    final public const PURCHASE_TYPE = 3;

    final public const RETURN_TYPE = 4;

    final public const QUOTATION_TYPE = 5;

    final public const PREVIEW_ACTION = 1;

    final public const DOWNLOAD_ACTION = 2;

    final public const EMAIL_ACTION = 3;
}
