<?php

namespace App\View\Components\Script\Select2;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WithImage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $name)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.script.select2.with-image');
    }
}
