<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $id;
    public $label;
    public $options;
    public $name;
    public $multiple;
    

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $options, $name, $multiple)
    {
        $this->id = $id;
        $this->label = $label;
        $this->options = $options;
        $this->name = $name;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form.select2');
    }
}
