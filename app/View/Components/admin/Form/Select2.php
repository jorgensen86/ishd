<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $id;
    public $options;
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $options, $name)
    {
        $this->id = $id;
        $this->options = $options;
        $this->name = $name;
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
