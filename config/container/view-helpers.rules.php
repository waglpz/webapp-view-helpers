<?php

declare(strict_types=1);

use Waglpz\Webapp\View\Helpers\Factory\Factory as ViewHelpersFactory;

/**
 *  Example registration
 *
    'dateFormat'  => DateFormatter::class,
    'modalDialog' => ModalDialog::class,
    'sortingButtons' => SortingButtons::class,
    'navigation'     => Navigation::class,
    'tabs'           => Tabs::class,
    'url'            => static fn (
        string $route,
        ?array $routeArguments = null,
        ?array $queryParams = null,
        int $retainHash = Url::RETAIN_HASH
    ): string => (new Url(webBase()))($route, $routeArguments, $queryParams, $retainHash),
    'pagination'     => Pagination::class,
 */
return [
    ViewHelpersFactory::class => [
        'shared'          => true,
        'instanceOf'      => ViewHelpersFactory::class,
        'constructParams' => [
            [
                'dateFormat' => \Waglpz\Webapp\View\Helpers\DateFormatter::class,
            ],
        ],
    ],
];
