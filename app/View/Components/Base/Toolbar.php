<?php

namespace App\View\Components\Base;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toolbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public ?array $breads = null,
        public ?array $actions = null,
        public bool $sticky = false,
        public bool $return = false,
        public bool $submit = false
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base.toolbar');
    }
}
