<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2 extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $label, public String $name, public $options, public $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = empty($selected) ? null : $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select2');
    }
}
