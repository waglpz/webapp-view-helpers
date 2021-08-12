<?php

declare(strict_types=1);

namespace Waglpz\View\Helpers\Factory;

use RuntimeException;
use Waglpz\View\Helpers\DateFormatter;
use Waglpz\View\Helpers\Tabs;

use function Waglpz\Webapp\container;

/**
 * @method DateFormatter dateFormat(\DateTimeInterface $time, string $pattern = 'd.MMMM.yyyy') : string
 * @method Tabs tabs() : Tabs
 */
final class Factory
{
    /** @var array<string,string|\Closure> */
    private array $helpers;

    /** @param array<string,string|\Closure> $helpers */
    public function __construct(array $helpers)
    {
        $this->helpers = $helpers;
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
            if (container()->has($viewHelperClass)) {
                $viewHelper = container()->get($this->helpers[$name]);

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
                    'Can not instatiate View Hlper "%s".',
                    $viewHelperClass
                )
            );
        }

        return new $this->helpers[$name](...$arguments);
    }
}
