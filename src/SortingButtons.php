<?php

declare(strict_types=1);

namespace Waglpz\View\Helpers;

final class SortingButtons
{
    private string $classes;
    private string $sortDesc;
    private string $sortAsc;

    public function __invoke(string $sortAsc, string $sortDesc, string ...$classes): self
    {
        $this->classes  = \implode(' ', $classes);
        $this->sortAsc  = $sortAsc;
        $this->sortDesc = $sortDesc;

        return $this;
    }

    public function __toString(): string
    {
        return <<<HTML
<span class="btn-group-vertical p-0 m-0 mr-2 {$this->classes}">
    <i class="fa fa-sort-asc btn btn-lg ml-n2 mb-n1 sortingButtons"
       aria-hidden="true"
       title="aufsteigend sortieren"
       onclick="window.location.href = '{$this->sortAsc}'"
    ></i>
    <i class="fa fa-sort-desc btn btn-lg ml-1 mt-n1 sortingButtons"
       aria-hidden="true"
       title="absteigend sortieren"
       onclick="window.location.href = '{$this->sortDesc}'"
    ></i>
</span>
HTML;
    }
}
