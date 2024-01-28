<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public String $label,
        public String $type = 'text',
        public  ? String $name = null,
        public  ? String $value = null,
        public  ? String $placeholder = null,
        public  ? String $attr = null,
        public  ? String $class = null,
    ) {
        $this->label       = ucwords($label);
        $this->name        = empty($name) ? str_replace(' ', '_', strtolower($label)) : $name;
        $name = $this->name;
        $this->value       = empty($value) ? $value : json_decode($value)->$name;
        $this->type        = $type;
        $this->placeholder = empty($placeholder) ? 'Enter ' . ucwords($label) : $placeholder;
        $this->attr        = $attr;
        $this->class       = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View | Closure | string
    {
        return view('components.form.input');
    }
}
