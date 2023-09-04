<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateAPIVirtualModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-a-p-i-virtual-models';

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

            // Generate the controller name based on the model name
            $chi = "$".$modelName;

            // Generate the property documentation for fillable attributes
            $modelClass = "\\App\\Models\\{$modelName}";
            $reflectionClass = new \ReflectionClass($modelClass);
            $fillableProperties = $reflectionClass->getProperty('fillable')->getValue(new $modelClass());

            $propertyDocs = '';
            foreach ($fillableProperties as $property) {
                $propertyDocs .= "    /**\n";
                $propertyDocs .= "     * @OA\Property(\n";
                $propertyDocs .= "     *     title=\"{$property}\",\n";
                $propertyDocs .= "     *     description=\"{$property} of the {$modelName} model\",\n";
                $propertyDocs .= "     *     example=\"\",\n"; // You can add example values here
                $propertyDocs .= "     * )\n";
                $propertyDocs .= "     *\n";
                $propertyDocs .= "     * @var \n"; // Add the data type of the property here
                $propertyDocs .= "     */\n";
                $propertyDocs .= "    public \${$property};\n";
            }

            // Generate the controller code with property documentation
            $controllerCode = <<<PHP
<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="{$modelName}",
 *     description="{$modelName} model",
 *     @OA\Xml(
 *         name="{$modelName}"
 *     )
 * )
 */
class {$modelName}
{
{$propertyDocs}
}

PHP;

            // Create the controller file in the virtual directory
            file_put_contents(app_path('Virtual') . "/Models/{$modelName}.php", $controllerCode);
        }

        $this->info('Virtual models generated successfully!');
    }
}
