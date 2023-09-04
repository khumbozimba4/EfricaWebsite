<?php

// Get the list of model files in the Models directory
$modelNameFiles = glob(__DIR__.'/app/Models/*.php');

// Loop through each model file
foreach ($modelNameFiles as $modelNameFile) {
    // Extract the model name from the file path
    $modelName = basename($modelNameFile, '.php');
    
    // Generate the controller name based on the model name
    $chi = "$".$modelName;

    // Generate the property documentation for fillable attributes
    $modelClass = "\\App\\Models\\{$modelName}";
    $reflectionClass = new ReflectionClass($modelClass);
    $fillableProperties = $reflectionClass->getProperty('fillable')->getValue(new $modelClass());

    $propertyDocs = '';
    foreach ($fillableProperties as $property) {
        $propertyDocs .= "    /**\n";
        $propertyDocs .= "     * @OA\Property(\n";
        $propertyDocs .= "     *     title=\"{$property}\",\n";
        $propertyDocs .= "     *     description=\"{$property} of the {$chi} model\",\n";
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

/**
 * @OA\Schema(
 *     title="{$chi}",
 *     description="{$chi} model",
 *     @OA\Xml(
 *         name="{$chi}"
 *     )
 * )
 */
class {$modelName}
{
{$propertyDocs}
}

PHP;

    // Create the controller file in the virtual directory
    file_put_contents(__DIR__.'/app/virtual/'.$modelName.'.php', $controllerCode);
}

echo "Virtual models generated successfully!";
