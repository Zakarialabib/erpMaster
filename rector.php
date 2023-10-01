<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/resources',
    ]);

    // register a single rule
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::PHP_80,
        SetList::PHP_81,
        SetList::PHP_82,
    ]);
};
