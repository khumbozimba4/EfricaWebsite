<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateSearchableModels extends Command
{
    protected $signature = 'searchable:generate';

    protected $description = 'Generate toSearchableArray function for all models.';
    public function handle(){
    // Get the list of model files from the Models folder
    $modelsFolder = app_path('Models');
    $filesystem = new Filesystem();
    $modelFiles = $filesystem->files($modelsFolder);

    // Read the searchable template file
    $searchableTemplate = file_get_contents(base_path('app/Console/Commands/searchable_template.txt'));

    foreach ($modelFiles as $modelFile) {
        $modelContent = file_get_contents($modelFile);

        // Check if the model already has the toSearchableArray() function
        if (strpos($modelContent, 'toSearchableArray') !== false) {
            continue; // Skip this model since the function already exists
        }

        // Get the fillable attributes for the model
        $fillableAttributes = [];
        preg_match("/protected\s+\$fillable\s*=\s*\[([^\]]+)\]/", $modelContent, $matches);
        if (isset($matches[1])) {
            $fillableAttributes = array_map('trim', explode(',', $matches[1]));
        }

        // Generate the toSearchableArray() function
        $searchableAttributes = $this->getSearchableAttributes($fillableAttributes);
        $searchableFunction = 'public function toSearchableArray()' . PHP_EOL
            . '{' . PHP_EOL
            . '    return [' . PHP_EOL
            . $searchableAttributes . PHP_EOL
            . '    ];' . PHP_EOL
            . '}' . PHP_EOL;

        // Insert the generated content inside the class
        $modelContent = preg_replace('/}(\s*)$/', "$1$1$searchableFunction$1}", $modelContent);

        // Update the model file with the modified content
        file_put_contents($modelFile, $modelContent);

        $this->info("Generated Searchable function for " . $this->getModelName($modelFile));
    }

    $this->info('Searchable functions generated for all models.');
}

private function getModelName($filePath)
{
    return pathinfo($filePath, PATHINFO_FILENAME);
}

private function getSearchableAttributes($fillableAttributes)
{
    $searchableAttributes = "    return [" . PHP_EOL;
    foreach ($fillableAttributes as $attribute) {
        if ($attribute !== 'created_at' && $attribute !== 'updated_at') {
            $searchableAttributes .= "        '$attribute' => \$this->$attribute," . PHP_EOL;
        }
    }
    $searchableAttributes .= "    ];";
    return $searchableAttributes;
}



    

}
