<?php

// Get the list of model files in the Model directory
 $modelNameFiles = glob(__DIR__.'/app/Models/*.php');
 $request = "$"."request";
 $id = "$"."id";
 $validator = "$"."validator";
foreach ( $modelNameFiles as  $modelNameFile) {
    // Extract the model name from the file path
     $modelName = basename($modelNameFile, '.php');
     $lowercasePath= strtolower($modelName);
    // Generate the controller name based on the model name
    $controllerName =  $modelName.'Controller';
    $chi = "$".$modelName;
    $variable = "$"."parent";
    $smallletter = strtolower($modelName).'s';
    // Generate the controller code
    $controllerCode = <<<PHP
<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\\{$modelName}Resource;
use App\Models\\{$modelName};
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\\{$modelName}ResourceCollection;
use Illuminate\Http\Response;
use App\Helpers\Validations;

/**
 * @OA\Tag(
     *     name="{$modelName}s",
     *     description="API Endpoints of {$modelName}s"
     * )
     
 */

class {$controllerName} extends Controller
{
    // Include the CRUD functions here (index, create, store, show, update, destroy)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/{$lowercasePath}/getAll{$modelName}s",
      *      operationId="getAll{$modelName}s",
      *      tags={"{$modelName}s"},
      *      summary="Get list of {$lowercasePath}s",
      *      description="Returns list of {$lowercasePath}s",
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/{$modelName}Resource")
      *       ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      )
      *     )
      */

    public function index(Request {$request})
    {
        {$chi} = {$modelName}::paginate(10); // Adjust the pagination limit as needed
        return {$request}->expectsJson()
            ? response()->json(['data' => new {$modelName}ResourceCollection($chi)], Response::HTTP_OK)
            : view('admin.{$smallletter}.{$smallletter}', ['{$smallletter}' => {$chi}]);
    }



    public function create()
    {
            return view('admin.{$smallletter}.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  {$request}
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *      path="/{$lowercasePath}/add{$modelName}",
      *      operationId="store{$modelName}",
      *      tags={"{$modelName}s"},
      *      summary="Store new {$lowercasePath}",
      *      description="Returns {$lowercasePath} data",
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/Store{$modelName}Request")
      *      ),
      *      @OA\Response(
      *          response=201,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/{$modelName}")
      *       ),
      *      @OA\Response(
      *          response=400,
      *          description="Bad Request"
      *      ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      )
      * )
      */

    public function store(Request {$request})
    {
        {$validator} = Validations::Validate{$modelName}Store($request);

        if ({$validator}->fails()) {
            return response()->json(['errors' => {$validator}->errors()], Response::HTTP_BAD_REQUEST);
        }

         {$chi} = {$modelName}::create({$request}->all());
         return response()->json(['data' => $chi], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  {$id}
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/{$lowercasePath}/{id}/get{$modelName}ById",
      *      operationId="get{$modelName}ById",
      *      tags={"{$modelName}s"},
      *      summary="Get {$lowercasePath} information",
      *      description="Returns {$lowercasePath} data",
      *      @OA\Parameter(
      *          name="id",
      *          description="{$modelName} id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/{$modelName}")
      *       ),
      *      @OA\Response(
      *          response=400,
      *          description="Bad Request"
      *      ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      )
      * )
      */

    public function show({$id})
    {
        {$chi} = {$modelName}::find({$id}); // find row by id

        // if row {$modelName} is not found, return 404 and status message
        if (!{$chi}) {
           return response()->json(['error' => '{$modelName} not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $chi], Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  {$request}
     * @param  int  {$id}
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Put(
      *      path="/{$lowercasePath}/{id}/update{$modelName}ById",
      *      operationId="update{$modelName}",
      *      tags={"{$modelName}s"},
      *      summary="Update existing {$lowercasePath}",
      *      description="Returns updated {$lowercasePath} data",
      *      @OA\Parameter(
      *          name="id",
      *          description="{$modelName} id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/Update{$modelName}Request")
      *      ),
      *      @OA\Response(
      *          response=202,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/{$modelName}")
      *       ),
      *      @OA\Response(
      *          response=400,
      *          description="Bad Request"
      *      ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      ),
      *      @OA\Response(
      *          response=404,
      *          description="Resource Not Found"
      *      )
      * )
      */

    public function update(Request {$request}, {$id})
    {
        {$validator} = Validations::Validate{$modelName}Store($request);


        if ({$validator}->fails()) {
            return response()->json(['errors' => {$validator}->errors()], Response::HTTP_BAD_REQUEST);
        }

        {$chi} = {$modelName}::find({$id}); // find row by id

        // if row {$modelName} is not found, return 404 and status message
        if (!{$chi}) {
           return response()->json(['error' => '{$modelName} not found'], Response::HTTP_NOT_FOUND);
         }
         {$chi}->update({$request}->all());

         return response()->json(['data' => $chi], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  {$id}
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Delete(
      *      path="/{$lowercasePath}/{id}/delete{$modelName}ById",
      *      operationId="delete{$modelName}",
      *      tags={"{$modelName}s"},
      *      summary="Delete existing {$lowercasePath}",
      *      description="Deletes a record and returns no content",
      *      @OA\Parameter(
      *          name="id",
      *          description="{$modelName} id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=204,
      *          description="Successful operation",
      *          @OA\JsonContent()
      *       ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      ),
      *      @OA\Response(
      *          response=404,
      *          description="Resource Not Found"
      *      )
      * )
      */

    public function destroy({$id})
    {
         {$chi} = {$modelName}::find({$id}); // find row by id

         // if row {$modelName} is not found, return 404 and status message
         if (!{$chi}) {
            return response()->json(['error' => '{$modelName} not found'], Response::HTTP_NOT_FOUND);
        }
         {$chi}->delete();

         return response()->json(null, Response::HTTP_NO_CONTENT);
        }
}

PHP;

    // Create the controller file in the API/V1 directory
    file_put_contents(__DIR__.'/app/Http/Controllers/API/V1/'.$controllerName.'.php', $controllerCode);
}

echo "Controllers generated successfully!";
