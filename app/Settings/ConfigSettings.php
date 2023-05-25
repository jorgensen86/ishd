<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ConfigSettings extends Settings
{

    public string $site_name;
    public int $maintenance;
    public int $results_per_page;

    public static function group(): string
    {
        return 'config';
    }
}