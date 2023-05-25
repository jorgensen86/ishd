<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\ConfigSettings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __invoke(ConfigSettings $settings){
        $settings->results_per_page = 2;
        $settings->save();
    }
}
