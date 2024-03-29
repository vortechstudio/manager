<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $accept = '.png, .jpg, .jpeg, .gif',
        public string $width = 'w-125px',
        public string $default = 'https://placehold.co/600x400',
        public bool $isModel = false,
        public ?string $model = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.image-input');
    }
}
