<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateAPIResourseUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-a-p-i-resourse-updates';

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
 
         // Get the model class
         $modelClass = "\\App\\Models\\{$modelName}";
 
         // Get the fillable attributes of the model
         $modelInstance = new $modelClass();
         $fillableAttributes = $modelInstance->getFillable();
 
         // Generate the request class code
         $requestClassCode = <<<PHP
 <?php
 namespace App\Virtual;
 
 /**
  * @OA\Schema(
  *      title="Update{$modelName} request",
  *      description="Update{$modelName} request body data",
  *      type="object",
  *      required={{$this->getRequiredAttributes($modelInstance)}}
  * )
  */
 class Update{$modelName}Request
 {
 {$this->generatePropertyDocs($fillableAttributes,$modelName)}
 }
 
 PHP;
 
         // Create the request class file in the Virtual directory
         $requestClassFileName = app_path("Virtual/Update{$modelName}Request.php");
         File::put($requestClassFileName, $requestClassCode);
     }
 
     $this->info('API request  classes for updates generated successfully!');
 }
 
 private function getRequiredAttributes($modelInstance)
 {
     $requiredAttributes = [];
     foreach ($modelInstance->getFillable() as $attribute) {
         if (in_array($attribute, ['created_at', 'updated_at','id']) || in_array($attribute, $modelInstance->getGuarded())) {
             continue; // Skip "created_at" and "updated_at" attributes, as well as guarded attributes
         }
         $requiredAttributes[] = '"' . $attribute . '"';
     }
     return implode(',', $requiredAttributes);
 }
 
 
 private function generatePropertyDocs($fillableAttributes, $modelName)
 {
     $propertyDocs = '';

     
     foreach ($fillableAttributes as $attribute) {
        if(!in_array($attribute,["created_at","updated_at","id"])){

        
         // Provide example values based on the attribute name (this is just a placeholder, use meaningful examples)
         $exampleValue = match ($attribute) {
             'name' => 'John Doe',
             'email' => 'johndoe@example.com',
             'phone' => '555-1234',
             default => 'Your example value here',
         };
 
         $propertyDocs .= <<<PHP
 
     /**
      * @OA\Property(
      *      title="{$attribute}",
      *      description="{$attribute} of the new {$modelName}",
      *      example="{$exampleValue}"
      * )
      *
      * @var string
      */
     public \${$attribute};
 
 PHP;
     }
    }
     return $propertyDocs;
 }
 
 }
 