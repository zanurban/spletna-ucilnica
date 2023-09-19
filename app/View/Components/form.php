<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $existingData,
        public string $submitRouteName,
        public string $backRouteName = 'home',
        public string $variableName = '',
        public string $submitButtonName = 'Shrani',
        public string $optionalVariableName = '',
        public string $optionalId = '',
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
