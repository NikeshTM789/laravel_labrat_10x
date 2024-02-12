<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $name, public String $label, public String|Int $value = 1, public Bool|Int $checked = false)
    {
        $this->name = $name;
        $this->label = ucwords($label);
        $this->value = $value;
        $this->checked = (Bool)($checked);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.checkbox');
    }
}
