<?php
/** @noinspection PhpUndefinedClassInspection */

declare(strict_types=1);

namespace Waglpz\View\Helpers;

use function Waglpz\Webapp\container;

if (! \function_exists('Waglpz\View\Helpers\viewHelpers')) {
    /** @return Factory\Factory&\_stub @phpstan-ignore-next-line */
    function viewHelpers() /* @phpstan-ignore-line */
    {
        static $viewHelpers = null;
        if ($viewHelpers === null) {
            $viewHelpers = container()->get(Factory\Factory::class);
        }

        /** @phpstan-var Factory\Factory&\_stub $viewHelpers*/

        return $viewHelpers; /* @phpstan-ignore-line */
    }
}
