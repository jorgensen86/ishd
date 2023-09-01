<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('config.site_name', 'Icop Support Help Desk');
        $this->migrator->add('config.maintenance', 0);
        $this->migrator->add('config.results_per_page', 15);
        $this->migrator->add('config.accepted_files', 'image/*, .pdf, .doc, .docx, .xls, .xlsx, .csv, .txt');
        $this->migrator->add('config.max_filesize', '2');
    }
};
