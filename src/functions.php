<?php
/** @noinspection PhpUndefinedClassInspection */

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

use Dice\Dice;

if (! \function_exists('Waglpz\Webapp\View\Helpers\viewHelpers')) {
    /** @return Factory\Factory&\_stub @phpstan-ignore-next-line */
    function viewHelpers()
    {
        static $viewHelpers = null;
        if ($viewHelpers === null) {
            if (\function_exists('Waglpz\Webapp\container')) {
                $container = \Waglpz\Webapp\container();
            } else {
                $dice      = new Dice();
                $dicRules  = include __DIR__ . '/../config/dic.rules.php';
                $dice      = $dice->addRules($dicRules);
                $container = new Container($dice);
            }

            $viewHelpers = $container->get(Factory\Factory::class);
            \assert($viewHelpers instanceof Factory\Factory);
            $viewHelpers->setContainer($container);
        }

        return $viewHelpers;
    }
}
