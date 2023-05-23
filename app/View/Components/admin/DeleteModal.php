<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class DeleteModal extends Component
{

    public $size;
    public $title;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */

    
    public function __construct($size, $title)
    {
        $this->size = $size;
        $this->title = $title;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.delete-modal');
    }
}
