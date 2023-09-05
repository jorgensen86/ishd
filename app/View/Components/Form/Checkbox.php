<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $active;
    public $label;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active, $label)
    {
        $this->active = $active;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.checkbox');
    }
}
