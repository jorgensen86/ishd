<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class Modal extends Component
{

    public $size;
    public $type;
    public $title;
    public $action;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    
    public function __construct($size, $type, $title)
    {
        $this->size = $size;
        $this->type = $type;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.modal');
    }
}
