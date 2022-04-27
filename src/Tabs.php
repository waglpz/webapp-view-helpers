<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

final class Tabs
{
    /** @var array<string>|null */
    private static ?array $wrapperClasses;
    /** @var array<string>|null */
    private static ?array $rootClasses;
    /** @var array<self> */
    private array $tabs;
    private string $active;
    private string $id;
    private string $disabled;
    private string $href;
    private string $label;
    /** @var array<string>|null */
    private ?array $classes;

    /**
     * @param  array<string> $rootElementClasses
     * @param  array<string> $wrapperClasses
     */
    public function __construct(?array $rootElementClasses = null, ?array $wrapperClasses = null)
    {
        self::$rootClasses    = $rootElementClasses;
        self::$wrapperClasses = $wrapperClasses;
        $this->active         = '';
        $this->disabled       = '';
        $this->label          = '';
        $this->href           = '#';
        $this->id             = '';
        $this->tabs           = [];
    }

    public function firstTab(): self
    {
        $this->tabs   = [];
        $this->tabs[] = $this;

        return $this;
    }

    public function nextTab(): self
    {
        $self         = new self(self::$rootClasses, self::$wrapperClasses);
        $self->tabs   = $this->tabs;
        $self->tabs[] = $self;

        return $self;
    }

    public function active(bool $is = true): self
    {
        $this->active = $is === true ? 'active' : '';

        return $this;
    }

    /** @param  array<string> $classes */
    public function classes(array $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    public function disabled(): self
    {
        $this->disabled = 'disabled';

        return $this;
    }

    public function id(string $id): self
    {
        foreach ($this->tabs as $tab) {
            if (\strcasecmp($tab->id, $id) === 0) {
                throw new \InvalidArgumentException(\sprintf('Id "%s" is already in use for another tab.', $id));
            }
        }

        $this->id = $id;

        return $this;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function href(string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function __toString(): string
    {
        $tabs                  = \array_reduce(
            $this->tabs,
            static function (string $acc, self $tab): string {
                $acc .= $tab->template();

                return $acc;
            },
            ''
        );
        $rootElementClasses    = \implode(
            ' ',
            self::$rootClasses ?? ['sticky-top', 'ml-n4', 'mr-n4', 'bg-white', 'shadow-sm']
        );
        $wrapperElementClasses = \implode(
            ' ',
            self::$wrapperClasses ?? [
                'position-relative',
                'nav',
                'nav-tabs',
                'pt-3',
                'pb-4',
                'ml-4',
                'mr-4',
                'border-0',
            ]
        );

        return <<<HTML
<nav class="{$rootElementClasses}"><div class="{$wrapperElementClasses}" role="tablist">${tabs}</div></nav>
HTML;
    }

    private function template(): string
    {
        $class = \implode(' ', $this->classes ?? ['nav-item', 'nav-link', 'mr-1', $this->active, $this->disabled]);

        return <<<HTML
<a class="{$class}" id="{$this->id}" href="{$this->href}" 
    role="tab" aria-controls="{$this->id}-tab" aria-selected="true">{$this->label}</a>
HTML;
    }
}
