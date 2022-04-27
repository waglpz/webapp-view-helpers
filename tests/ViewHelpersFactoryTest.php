<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers\Tests;

use Dice\Dice;
use PHPUnit\Framework\TestCase;
use Waglpz\Webapp\View\Helpers\Container;
use Waglpz\Webapp\View\Helpers\Factory\Factory;

final class ViewHelpersFactoryTest extends TestCase
{
    public function createContainer(): Container
    {
        $dice     = new Dice();
        $dicRules = include __DIR__ . '/../config/dic.rules.php';
        $dice     = $dice->addRules($dicRules);

        return new Container($dice);
    }

    /** @test */
    public function fehlerWirdProduziertBeimHolenUnbekannterViewHelper(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectErrorMessage(\sprintf('Unbekannter View Helper %s', 'unknown'));
        $helpers            = [];
        $container          = $this->createContainer();
        $viewHelpersFactory = new Factory($helpers);
        $viewHelpersFactory->setContainer($container);
        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $viewHelpersFactory->unknown();
    }

    /** @test */
    public function viewHelperWirdProduziertAusClosure(): void
    {
        $helpers = [
            'toUC' => static fn ($param = null) => $param ? \strtoupper($param) : '',
        ];

        $container          = $this->createContainer();
        $viewHelpersFactory = new Factory($helpers);
        $viewHelpersFactory->setContainer($container);

        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $fact = $viewHelpersFactory->toUC('arg1');
        self::assertSame('ARG1', $fact);
        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        self::assertSame('', $viewHelpersFactory->toUC());
        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        self::assertSame('', $viewHelpersFactory->toUC(false));
    }

    /** @test */
    public function viewHelperWirdProduziertAusClass(): void
    {
        $helper = new class () {
            public function __toString(): string
            {
                return 'test ok';
            }
        };

        $helpers            = [
            'class' => \get_class($helper),
        ];
        $container          = $this->createContainer();
        $viewHelpersFactory = new Factory($helpers);
        $viewHelpersFactory->setContainer($container);

        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $fact = $viewHelpersFactory->class();
        self::assertEquals('test ok', $fact);
        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $helper1 = $viewHelpersFactory->class();
        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $helper2 = $viewHelpersFactory->class();
        self::assertNotSame($helper1, $helper2);
    }

    /** @test */
    public function viewHelperWirdProduziertAusInvokableClass(): void
    {
        $helper = new class () {
            public function __invoke(string $arg): string
            {
                return $arg . ' test ok';
            }
        };

        $helpers            = [
            'class' => \get_class($helper),
        ];
        $container          = $this->createContainer();
        $viewHelpersFactory = new Factory($helpers);
        $viewHelpersFactory->setContainer($container);

        /** @noinspection PhpUndefinedMethodInspection */
        /** @phpstan-ignore-next-line */
        $fact = $viewHelpersFactory->class('Helper');
        self::assertEquals('Helper test ok', $fact);
    }
}
