<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class CreateRepository extends Command
{
    const TEMPLATE_PATH = 'Console/FileTemplates/RepositoryTemplate';
    
    protected $signature = 'make:repository {name}';

    protected $description = 'Creating new repository in /app/Repositories';

    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path('Repositories');

        $filePath = $path . '/' . $name . 'Repository.php';

        $templatePath = app_path(self::TEMPLATE_PATH);

        $template = file_get_contents($templatePath);
        $template = str_replace('{RepositoryName}', $name, $template);
        File::put($filePath, $template);
        $this->info('Repository created');
    }
}
