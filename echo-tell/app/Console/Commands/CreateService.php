<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class CreateService extends Command
{
    const TEMPLATE_PATH = 'Console/FileTemplates/ServiceTemplate';

    protected $signature = 'make:service {name}';

    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');

        $template = app_path(self::TEMPLATE_PATH);

        $filePath = app_path('Services') . '/' . $name . 'Service.php';
        $template = file_get_contents($template);
        $template = str_replace('{ServiceName}', $name, $template);
        File::put($filePath, $template);
        $this->info('Service created');
    }
}
