<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers\Factory;

use Psr\Container\ContainerInterface;
use RuntimeException;
use Waglpz\Webapp\View\Helpers\DateFormatter;
use Waglpz\Webapp\View\Helpers\SortingButtons;
use Waglpz\Webapp\View\Helpers\Tabs;

/**
 * @method DateFormatter dateFormat($time, string $pattern = 'd.MMMM.yyyy') : string
 * @method SortingButtons sortingButtons() : Tabs
 * @method Tabs tabs() : Tabs
 */
final class Factory
{
    /** @var array<string,string|\Closure> */
    private array $helpers;
    private ContainerInterface $container;

    /** @param array<string,string|\Closure> $helpers */
    public function __construct(array $helpers)
    {
        $this->helpers = $helpers;
    }

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @param array<mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (! isset($this->helpers[$name])) {
            throw new RuntimeException(\sprintf('Unbekannter View Helper %s', $name));
        }

        if ($this->helpers[$name] instanceof \Closure) {
            return $this->helpers[$name](...$arguments);
        }

        if (\method_exists($this->helpers[$name], '__invoke')) {
            $viewHelperClass = $this->helpers[$name];
            if ($this->container->has($viewHelperClass)) {
                $viewHelper = $this->container->get($this->helpers[$name]);

                if (\is_callable($viewHelper)) {
                    return $viewHelper(...$arguments);
                }

                throw new RuntimeException(
                    \sprintf(
                        'Trying to invoke View Helper "%s" but it might not be a callable.',
                        $viewHelperClass
                    )
                );
            }

            throw new RuntimeException(
                \sprintf(
                    'Can not instantiate View Helper "%s".',
                    $viewHelperClass
                )
            );
        }

        return new $this->helpers[$name](...$arguments);
    }
}
