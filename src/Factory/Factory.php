<?php

declare(strict_types=1);

namespace Waglpz\View\Helpers\Factory;

use RuntimeException;
use Waglpz\View\Helpers\DateFormatter;
use Waglpz\View\Helpers\Tabs;

/**
 * @method DateFormatter dateFormat(\DateTimeInterface $time, string $pattern = 'd.MMMM.yyyy') : string
 * @method Tabs tabs() : Tabs
 */
final class Factory
{
    /** @param array<string,string|\Closure> $helpers */
    public function __construct(private array $helpers)
    {
    }

    /** @param array<mixed> $arguments */
    public function __call(string $name, array $arguments): mixed
    {
        if (! isset($this->helpers[$name])) {
            throw new RuntimeException(\sprintf('Unbekannter View Helper %s', $name));
        }

        if ($this->helpers[$name] instanceof \Closure) {
            return $this->helpers[$name](...$arguments);
        }

        $callable = new $this->helpers[$name]();

        if (\method_exists($callable, '__invoke')) {
            return $callable(...$arguments);
        }

        return new $this->helpers[$name](...$arguments);
    }
}
