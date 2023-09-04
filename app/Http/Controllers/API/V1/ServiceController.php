<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResourceCollection;
use Illuminate\Http\Response;
use App\Helpers\Validations;

/**
 * @OA\Tag(
     *     name="Services",
     *     description="API Endpoints of Services"
     * )
     
 */

class ServiceController extends Controller
{
    // Include the CRUD functions here (index, create, store, show, update, destroy)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/service/getAllServices",
      *      operationId="getAllServices",
      *      tags={"Services"},
      *      summary="Get list of services",
      *      description="Returns list of services",
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/ServiceResource")
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

    public function index(Request $request)
    {
        $Service = Service::paginate(10); // Adjust the pagination limit as needed
        return $request->expectsJson()
            ? response()->json(['data' => new ServiceResourceCollection($Service)], Response::HTTP_OK)
            : view('admin.services.services', ['services' => $Service]);
    }



    public function create()
    {
            return view('admin.services.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *      path="/service/addService",
      *      operationId="storeService",
      *      tags={"Services"},
      *      summary="Store new service",
      *      description="Returns service data",
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/StoreServiceRequest")
      *      ),
      *      @OA\Response(
      *          response=201,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Service")
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

    public function store(Request $request)
    {
        $validator = Validations::ValidateServiceStore($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

         $Service = Service::create($request->all());
         return response()->json(['data' => $Service], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/service/{id}/getServiceById",
      *      operationId="getServiceById",
      *      tags={"Services"},
      *      summary="Get service information",
      *      description="Returns service data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Service id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Service")
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

    public function show($id)
    {
        $Service = Service::find($id); // find row by id

        // if row Service is not found, return 404 and status message
        if (!$Service) {
           return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $Service], Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Put(
      *      path="/service/{id}/updateServiceById",
      *      operationId="updateService",
      *      tags={"Services"},
      *      summary="Update existing service",
      *      description="Returns updated service data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Service id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/UpdateServiceRequest")
      *      ),
      *      @OA\Response(
      *          response=202,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Service")
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

    public function update(Request $request, $id)
    {
        $validator = Validations::ValidateServiceStore($request);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $Service = Service::find($id); // find row by id

        // if row Service is not found, return 404 and status message
        if (!$Service) {
           return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
         }
         $Service->update($request->all());

         return response()->json(['data' => $Service], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Delete(
      *      path="/service/{id}/deleteServiceById",
      *      operationId="deleteService",
      *      tags={"Services"},
      *      summary="Delete existing service",
      *      description="Deletes a record and returns no content",
      *      @OA\Parameter(
      *          name="id",
      *          description="Service id",
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

    public function destroy($id)
    {
         $Service = Service::find($id); // find row by id

         // if row Service is not found, return 404 and status message
         if (!$Service) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
         $Service->delete();

         return response()->json(null, Response::HTTP_NO_CONTENT);
        }
}
