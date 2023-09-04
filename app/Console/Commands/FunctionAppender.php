<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class FunctionAppender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:function-appender';

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
        $modelsDirectory = app_path('Models');
        $validationClass = app_path('Helpers/Validations.php');

        $generatedFunctions = [];

        foreach (File::files($modelsDirectory) as $modelFile) {
            $className = "\\App\\Models\\" . pathinfo($modelFile, PATHINFO_FILENAME);

            if (!class_exists($className)) {
                continue;
            }

            $functionTemplate = $this->generateValidationFunction($className);
            $generatedFunctions[] = $functionTemplate;
        }

        if (empty($generatedFunctions)) {
            $this->info("No models found or all models already have validation functions.");
            return;
        }

        // Append all generated validation functions inside the Validations class
        $content = File::get($validationClass);
        $content = preg_replace('/class Validations\s*\{/', "class Validations {" . PHP_EOL . implode(PHP_EOL, $generatedFunctions), $content);
        File::put($validationClass, $content);

        $this->info("Validation functions for all models have been appended successfully.");
    }

    protected function generateValidationFunction($className)
    {
        $modelName = class_basename($className);
        $functionName = 'validate' . $modelName . 'Store';
        $fillableAttributes = $className::make()->getFillable();
        $validationRules = '';

        foreach ($fillableAttributes as $attribute) {
            if (!in_array($attribute,['id','created_at','updated_at'])) {
                # code...
                $validationRules .= "\t\t\t'{$attribute}' => 'required',\n";
            }
        }

        $functionTemplate = <<<EOT

    /**
     * Validate the input data for storing a new {$modelName}.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function {$functionName}(\$request)
    {
        \$validator = Validator::make(\$request->all(), [
{$validationRules}
        ]);

        return \$validator;
    }

EOT;

        return $functionTemplate;
    }
}
