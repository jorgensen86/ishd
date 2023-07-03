<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class InputGroup extends Component
{

    public $icon;
    public $inputName;
    public $value;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $inputName, $value, $placeholder)
    {
        $this->icon = $icon;
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
        return view('components.admin.form.input-group');
    }
}
