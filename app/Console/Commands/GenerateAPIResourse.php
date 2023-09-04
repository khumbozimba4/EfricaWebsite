<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class GenerateAPIResourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-a-p-i-resourse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the list of model files in the Models directory
        $modelNameFiles = glob(app_path('Models') . '/*.php');

        // Loop through each model file
        foreach ($modelNameFiles as $modelNameFile) {
            // Extract the model name from the file path
            $modelName = basename($modelNameFile, '.php');

            // Generate the resource class code
            $resourceClassCode = <<<PHP
<?php
namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="{$modelName}Resource",
 *     description="{$modelName} resource",
 *     @OA\Xml(
 *         name="{$modelName}Resource"
 *     )
 * )
 */
class {$modelName}Resource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\\{$modelName}[]
     */
    private \$data;
}

PHP;

            // Create the resource class file in the Virtual/Resource directory
            $resourceClassFileName = app_path("Virtual/Resources/{$modelName}Resource.php");
            File::put($resourceClassFileName, $resourceClassCode);
        }

        $this->info('Resource classes generated successfully!');
    }
}
