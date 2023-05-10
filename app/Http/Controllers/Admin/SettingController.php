<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        return view('layouts.admin.setting.settingForm', ['class' => 'setting-page', 'heading_title' => 'Settings']);
    }

    public function store() {
        dd(request()->all());
    }
}
