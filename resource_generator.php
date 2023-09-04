<?php

// Get the list of model files in the Model directory
$modelFiles = glob(__DIR__.'/app/Models/*.php');

foreach ($modelFiles as $modelFile) {
    // Extract the model name from the file path
    $modelName = basename($modelFile, '.php');

    // Generate the resource collection name based on the model name
    $resourceCollectionName = $modelName.'ResourceCollection';

    // Generate the resource collection code
    $resourceCollectionCode = <<<PHP
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class {$resourceCollectionName} extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return array
     */
    public function toArray(\$request)
    {
        return \$this->collection;
    }
}

PHP;

    // Create the resource collection file in the Http/Resources directory
    file_put_contents(__DIR__.'/app/Http/Resources/'.$resourceCollectionName.'.php', $resourceCollectionCode);
}

echo "Resource collections generated successfully!";
