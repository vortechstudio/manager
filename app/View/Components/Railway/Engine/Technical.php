<?php

namespace App\View\Components\Railway\Engine;

use App\Models\Railway\Engine\RailwayEngine;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Technical extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public RailwayEngine $engine)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.railway.engine.technical');
    }
}
