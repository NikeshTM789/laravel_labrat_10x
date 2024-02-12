<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Editor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $label, public String $name, public $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = empty($value) ? $value : json_decode($value)->$name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.editor');
    }
}
