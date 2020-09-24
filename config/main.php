<?php

declare(strict_types=1);

return [
    'view'              => [
        'view_helper_factory' => \Waglpz\View\Helpers\Factory\Factory::class,
    ],
    'viewHelpers'       => [
        'dateFormat' => \Waglpz\View\Helpers\DateFormatter::class,
    ],
];
