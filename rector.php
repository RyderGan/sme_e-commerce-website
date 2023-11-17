<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/OurProducts',
        __DIR__ . '/admin',
        __DIR__ . '/css',
        __DIR__ . '/dompdf',
        __DIR__ . '/image',
        __DIR__ . '/inc',
        __DIR__ . '/js',
        __DIR__ . '/sql',
        __DIR__ . '/women',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    //    $rectorConfig->sets([
    //        LevelSetList::UP_TO_PHP_82
    //    ]);
};
