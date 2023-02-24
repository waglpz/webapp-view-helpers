<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

final class DateFormatter
{
    private \DateTimeInterface $datetime;

    /**
     * for pattern values see
     * http://userguide.icu-project.org/formatparse/datetime#TOC-DateTimePatternGenerator
     */
    public function __construct(mixed $datetime, private string $pattern = 'dd MMM yyyy HH:mm')
    {
        if ($datetime instanceof \DateTimeInterface) {
            $this->datetime = $datetime;

            return;
        }

        if ($datetime === null) {
            $this->datetime = new \DateTimeImmutable();

            return;
        }

        if (\is_int($datetime)) {
            $this->datetime = (new \DateTimeImmutable())->setTimestamp($datetime);

            return;
        }

        if (! \is_string($datetime)) {
            throw new \InvalidArgumentException(
                'Invalid "$dateTime" given. One of int, null, string or DatetimeImmutable type is valid.',
            );
        }

        $datetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $datetime);

        if ($datetime === false) {
            throw new \InvalidArgumentException(
                'Invalid "$dateTime" can not create Datetime Instance from given value.',
            );
        }

        $this->datetime = $datetime;
    }

    public function __toString(): string
    {
        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(),
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::SHORT,
        );
        $formatter->setPattern($this->pattern);
        /** @phpstan-var string $formatted */
        $formatted = $formatter->format($this->datetime);
        if ($formatter->getErrorCode() !== \U_ZERO_ERROR) {
            throw new \RuntimeException(
                $formatter->getErrorMessage(),
                $formatter->getErrorCode(),
            );
        }

        return $formatted;
    }
}
