<?php

declare(strict_types=1);

return [
    'view'              => [
        'view_helper_factory' => \Waglpz\Webapp\View\Helpers\Factory\Factory::class,
    ],
    'viewHelpers'       => [
        'dateFormat' => \Waglpz\Webapp\View\Helpers\DateFormatter::class,
    ],
];
