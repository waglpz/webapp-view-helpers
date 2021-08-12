<?php

declare(strict_types=1);

use Waglpz\View\Helpers\Factory\Factory as ViewHelpersFactory;

return [
    ViewHelpersFactory::class => [
        'shared' => true,
        'instanceOf' => ViewHelpersFactory::class,
        'constructParams' => ['dataFormat' => \Waglpz\View\Helpers\DateFormatter::class],
    ],
];
