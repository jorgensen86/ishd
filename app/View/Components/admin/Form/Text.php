<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Text extends Component
{
    public $labelFor;
    public $inputName;
    public $value;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($labelFor, $inputName, $value, $placeholder)
    {
        $this->labelFor = $labelFor;
        $this->inputName = $inputName;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form.text');
    }
}
