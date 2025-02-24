<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class CreateRepository extends Command
{
    const TEMPLATE_PATH = 'Console/FileTemplates/RepositoryTemplate';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating new repository in /app/Repositories';

    /**
     * Execute the console command.
     */
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
