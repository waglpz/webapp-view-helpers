<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

use Dice\Dice;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Waglpz\Webapp\View\Helpers\Factory\Factory;

use function Waglpz\Config\projectRoot;

if (! \function_exists('Waglpz\Webapp\View\Helpers\viewHelpers')) {
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function viewHelpers(): Factory
    {
        static $viewHelpers = null;
        if ($viewHelpers === null) {
            if (\function_exists('Waglpz\Webapp\container')) {
                $container = \Waglpz\DiContainer\container();
            } else {
                $dice      = new Dice();
                $dicRules  = include projectRoot() . '/dic.rules.php';
                $dice      = $dice->addRules($dicRules);
                $container = new Container($dice);
            }

            $viewHelpers = $container->get(Factory::class);
            \assert($viewHelpers instanceof Factory);
            $viewHelpers->setContainer($container);
        }

        return $viewHelpers;
    }
}
