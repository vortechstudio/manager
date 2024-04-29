<?php

namespace App\View\Components\Script;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tagify extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $selector, public bool $noElement = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.script.tagify');
    }
}
