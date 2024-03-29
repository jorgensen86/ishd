<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $options, $selected)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form.select');
    }
}
