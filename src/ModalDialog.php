<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

abstract class ModalDialog
{
    final private function __construct()
    {
    }

    /** @var array<self> */
    private static array $self;

    private string $id;
    private string $title;
    private string $body;
    private string|null $action = null;
    private string $close;
    private string $modalSizeClass = '';
    private string $wrapper;

    public function __toString(): string
    {
        if (isset(self::$self) && \count(self::$self) > 0) {
            return \array_reduce(
                self::$self,
                static fn (string $acc, self $instance) => $acc .= $instance->toString(),
                '',
            );
        }

        return '';
    }

    public function exampleModelWindow(string $actionUrl = '#'): self
    {
        if (isset(self::$self[__FUNCTION__])) {
            return self::$self[__FUNCTION__];
        }

        $self                     = new static();
        self::$self[__FUNCTION__] = $self;
        $self->id                 = __FUNCTION__;
        $self->title              = 'Delete example data';
        $self->wrapper            = '<form action="'
            . $actionUrl
            . '" method="post" novalidate class="needs-validation">%s</form>';
        $self->body               = <<<'HTML'
<p class="m-0 p-0 mb-3">Soll der Workflow wirklich unwiderruflich gelöscht werden?</p>
HTML;

        $self->action = <<<'HTML'
<button class="btn btn-danger ml-2" type="submit">Workflow löschen</button>
HTML;
        $self->close  = <<<'HTML'
<button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cancel</button>
HTML;

        return self::$self[__FUNCTION__];
    }

    /* phpcs:disable */
    private function toString(): string
    {
        /* phpcs:enable */
        $html = <<<HTML
<div class="modal fade" id="{$this->id}"
     tabindex="-1" role="dialog"
     aria-labelledby="{$this->title}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {$this->modalSizeClass}" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{$this->title}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">{$this->body}</div>
            <div class="modal-footer">
                {$this->close}                
                {$this->action}                
            </div>
        </div>
    </div>
</div>
HTML;

        return isset($this->wrapper) ? \sprintf($this->wrapper, $html) : $html;
    }

    public function id(): string
    {
        return $this->id;
    }
}
