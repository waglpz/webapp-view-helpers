<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

abstract class Pagination
{
    final private function __construct()
    {
    }

    public function __invoke(int $page, int $maxItemsPerPage, int $total): string
    {
        return (new static())->html($page, $maxItemsPerPage, $total);
    }

    private function prevLink(int $page): string
    {
        $class = $page - 1 === 0 ? 'disabled' : '';
        $href  = $this->url($page - 1);

        return <<<HTML
<li class="page-item {$class}"><a class="page-link" href="{$href}" tabindex="-1">Vorherige Seite</a></li>
HTML;
    }

    private function selector(int $page, int $total, int $maxItemsPerPage): string
    {
        $_total = $total;
        $index  = 0;
        $left   = $right = $select = '';

        while ($total > 0) {
            $total -= $maxItemsPerPage;
            ++$index;
            $skip = 5;
            if ($index <= $skip) {
                $left .= \sprintf(
                    '<li class="page-item"><a class="page-link %s" href="%s">%d</a></li>',
                    $index === $page ? 'alert-info ' : '',
                    $this->url($index),
                    $index,
                );
            } elseif ($index - 1 >= $_total / $maxItemsPerPage - $skip) {
                $right .= \sprintf(
                    '<li class="page-item"><a class="page-link %s" href="%s">%d</a></li>',
                    $index === $page ? 'alert-info' : '',
                    $this->url($index),
                    $index,
                );
            } else {
                $select .= \sprintf('<option value="%s">%d</option>', $this->url($index), $index);
            }
        }

        if ($select !== '') {
            $select = <<<HTML
<li class="page-item pr-2">
<select onchange="window.location.href=this.value" class="custom-select ml-1 pt-1">
<option>aktuelle Seite {$page}</option>
<optgroup class="mt-2" label="schnell zur Seite">{$select}</optgroup></select>
</li>
HTML;
        }

        return $left . $select . $right;
    }

    private function nextLink(int $page, int $maxItemsPerPage, int $total): string
    {
        $class = $page * $maxItemsPerPage >= $total ? 'disabled' : '';

        return <<<HTML
<li class="page-item  {$class}"><a class="page-link" href="{$this->url($page + 1)}">Nächste Seite</a></li>
HTML;
    }

    private function html(int $page, int $maxItemsPerPage, int $total): string
    {
        return <<<HTML
<nav aria-label="Workflow History Pagination">
    <ul class="pagination justify-content-center">
    {$this->prevLink($page)}
    {$this->selector($page, $total, $maxItemsPerPage)}
    {$this->nextLink($page, $maxItemsPerPage, $total)}
    </ul>
</nav>
HTML;
    }

    /**
     * pls implement this method to get url for needed page
     * eg //return viewHelpers()->url(Routes::HISTORY, null, ['page' => $page], Url::RETAIN_HASH);
     */
    abstract protected function url(int $page): string;
}
