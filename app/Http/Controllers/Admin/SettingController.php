<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\ConfigSettings;

class SettingController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.setting';
    const LANG_PATH = 'setting.';

    public function index(ConfigSettings $configSettings) {
        return view(self::LAYOUT_PATH . 'Form', [
            'title' => __(self::LANG_PATH . 'title'),
            'data' => $configSettings
        ]);
    }

    public function store(ConfigSettings $configSettings) {

        foreach (request()->all() as $key => $value) {
            if($key !== '_token') {
                $configSettings->$key = $value;
            }
            
            $configSettings->save();
        }
        // $configSettings->site_name = request()->input('site_name');
        // $configSettings->results_per_page = request()->input('results_per_page');
        // $configSettings->maintenance = request()->input('maintenance');
        // $configSettings->save();
        // return redirect()->back();
    }
}
