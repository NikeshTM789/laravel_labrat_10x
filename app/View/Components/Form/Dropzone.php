<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropzone extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $action, public String $label)
    {
        $this->action = $action;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.dropzone');
    }
}
