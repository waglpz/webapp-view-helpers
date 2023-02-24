<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers\Tests;

use PHPUnit\Framework\TestCase;
use Waglpz\Webapp\View\Helpers\DateFormatter;

final class DateFormatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider validDateTimes
     */
    public function formatOk(mixed $datetime, mixed $expectation): void
    {
        $sut = new DateFormatter($datetime);
        self::assertEquals($expectation, (string) $sut);
    }

    /** @return \Generator<mixed> */
    public static function validDateTimes(): \Generator
    {
        $formatter = new \IntlDateFormatter(
            'de-DE',
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::SHORT,
        );
        $formatter->setPattern('dd MMM yyyy HH:mm');

        yield 'string 2044-04-04 14:44:44' => ['2044-04-04 14:44:44', '04 Apr. 2044 14:44'];
        yield 'null' => [null, $formatter->format(new \DateTimeImmutable())];
        yield 'int' => [1628780154, '12 Aug. 2021 14:55'];
        yield 'instance' => [new \DateTimeImmutable(), $formatter->format(new \DateTimeImmutable())];
    }

    /**
     * @test
     * @dataProvider invalidDateTimes
     */
    public function throwsException(mixed $datetime): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid "$dateTime" can not create Datetime Instance from given value.',
        );
        new DateFormatter($datetime);
    }

    /** @return \Generator<mixed> */
    public static function invalidDateTimes(): \Generator
    {
        yield 'string 2044-04-100' => ['2044-04-100'];
        yield 'string wrong' => ['wrong'];
        yield 'string 100' => ['100'];
    }
}
