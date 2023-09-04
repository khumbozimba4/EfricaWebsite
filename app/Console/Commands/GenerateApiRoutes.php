<?php

namespace App\Console\Commands;

use App\Helpers\RouteRegistrar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateApiRoutes extends Command
{
    protected $signature = 'generate:api-routes';
    protected $description = 'Generate API routes based on the controllers';

    public function handle()
    {
        $apiRoutesContent = "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n";

        $controllerPath = app_path('Http/Controllers/API/V1');
        $controllerFiles = File::files($controllerPath);

        foreach ($controllerFiles as $controllerFile) {
            $controllerName = pathinfo($controllerFile->getFilename(), PATHINFO_FILENAME);
            $routeName = strtolower(str_replace('Controller', '', $controllerName));
            $controllerClass = "App\\Http\\Controllers\\API\\V1\\{$controllerName}";

            // Check if the controller class exists and is a valid class
            if (class_exists($controllerClass)) {

                $apiRoutesContent .= "// Routes for {$controllerName}\n";

                $routeRegistrar = new RouteRegistrar($routeName, $controllerClass);
                $routeDefinitions = $routeRegistrar->getRouteDefinitions();
                $apiRoutesContent .= implode("\n", $routeDefinitions) . "\n";

                $apiRoutesContent .= "\n\n";
            }
        }

        $apiRoutesPath = base_path('routes/api.php');
        File::put($apiRoutesPath, $apiRoutesContent);

        $this->info('API routes generated successfully!');
    }
}
