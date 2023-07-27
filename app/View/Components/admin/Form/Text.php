<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Text extends Component
{
    public $id;
    public $name;
    public $value;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name, $value, $placeholder)
    {
        $this->id = $id;
        $this->name = $name;
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
