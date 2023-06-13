<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\ConfigSettings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.setting';
    const LANG_PATH = 'admin/setting/setting.';
    const PAGE_CLASS = 'settingPage';

    public function index(ConfigSettings $configSettings) {
        return view(self::LAYOUT_PATH . 'Form', [
            'title' => __(self::LANG_PATH . 'title'),
            'site_name' => $configSettings->site_name,
            'results_per_page' => $configSettings->results_per_page,
            'maintenance' => $configSettings->maintenance
        ]);
    }

    public function store(ConfigSettings $configSettings) {
        $configSettings->site_name = request()->input('site_name');
        $configSettings->results_per_page = request()->input('results_per_page');
        $configSettings->maintenance = request()->input('maintenance');
        
        $configSettings->save();
        
        return redirect()->back();
    }
}
