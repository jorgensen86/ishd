<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ConfigSettings extends Settings
{

    public string $site_name;
    public int $maintenance;
    public int $results_per_page;
    public string $accepted_files;
    public float $max_filesize;

    public static function group(): string
    {
        return 'config';
    }
}