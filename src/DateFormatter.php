<?php

declare(strict_types=1);

namespace Waglpz\View\Helpers;

final class DateFormatter
{
    private \DateTimeInterface $dateTime;
    private string $pattern;

    /**
     * for pattern values see http://userguide.icu-project.org/formatparse/datetime#TOC-DateTimePatternGenerator
     */
    public function __construct(\DateTimeInterface $dateTime, string $pattern = 'd.MMMM.yyyy')
    {
        $this->dateTime = $dateTime;
        $this->pattern  = $pattern;
    }

    public function __toString(): string
    {
        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(),
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::SHORT
        );
        $formatter->setPattern($this->pattern);

        $formatted = $formatter->format($this->dateTime);
        if ($formatter->getErrorCode() !== \U_ZERO_ERROR) {
            throw new \RuntimeException($formatter->getErrorMessage(), $formatter->getErrorCode());
        }

        /** @noinspection MagicMethodsValidityInspection */
        return $formatted;
    }
}
