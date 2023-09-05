<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class OpenButton extends Component
{
    public $target;
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($target, $url)
    {
        $this->target = $target;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.open-button');
    }
}
