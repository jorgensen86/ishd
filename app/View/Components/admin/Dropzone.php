<?php

namespace App\View\Components\Admin;

use App\Settings\ConfigSettings;
use Illuminate\View\Component;

class Dropzone extends Component
{
    public $action;
    public $formId;
    public $accepted_files;
    public $max_filesize;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $formId, ConfigSettings $configSettings)
    {
        $this->action = $action;
        $this->formId = $formId;
        $this->accepted_files = $configSettings->accepted_files;
        $this->max_filesize = $configSettings->max_filesize;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.dropzone');
    }
}
