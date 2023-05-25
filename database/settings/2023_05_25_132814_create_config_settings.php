<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('config.site_name', 'Icop Support Help Desk');
        $this->migrator->add('config.maintenance', 0);
        $this->migrator->add('config.results_per_page', 2);
    }
};
