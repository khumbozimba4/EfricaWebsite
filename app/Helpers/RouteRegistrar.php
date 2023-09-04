<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
    protected $controllerName;
    protected $controllerClass;

    public function __construct($controllerName, $controllerClass)
    {
        $this->controllerName = $controllerName;
        $this->controllerClass = $controllerClass;
    }

    public function getRouteDefinitions()
    {
        $routeDefinitions = [];

        $controllerMethods = get_class_methods($this->controllerClass);

        foreach ($controllerMethods as $method) {
            if ($method !== '__construct' && strpos($method, '__') !== 0) {
                $routeMethod = $this->getRouteMethod($method);
                $routePath = "/v1/{$this->controllerName}";
                if(in_array($method,['show', 'update', 'destroy','store','index'])){

                if (in_array($method, ['show', 'update', 'destroy'])) {
                    $routePath .= '/{id}';
                }
                $description = null;
                $routeAction = "{$this->controllerClass}@{$method}";
                if ($method=="index") {
                    # code...
                    $description = "getAll".ucfirst($this->controllerName)."s";
                } else if($method=="update") {
                    # code...
                    $description = "update". ucfirst($this->controllerName)."ById";

                }
                 else if($method=="destroy") {
                    # code...
                    $description = "delete". ucfirst($this->controllerName)."ById";

                }
                 else if($method=="show") {
                    # code...
                    $description = "get". ucfirst($this->controllerName)."ById";

                }else{
                    $description = "add". ucfirst($this->controllerName);

                }
                if($description != null){

                    // Generate the route definition
                    $routeDefinition = "Route::{$routeMethod}('{$routePath}/{$description}', '{$routeAction}')->name('{$description}');";
                    $routeDefinitions[] = $routeDefinition;
                }
            }
            }
        }

        return $routeDefinitions;
    }

    protected function getRouteMethod($methodName)
    {
        $methodName = strtolower($methodName);
        if ($methodName === 'index' || $methodName === 'show') {
            return 'get';
        } elseif ($methodName === 'store') {
            return 'post';
        } elseif ($methodName === 'update') {
            return 'put';
        } elseif ($methodName === 'destroy') {
            return 'delete';
        } else {
            return 'post';
        }
    }
}
