<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResourceCollection;
use Illuminate\Http\Response;
use App\Helpers\Validations;

/**
 * @OA\Tag(
     *     name="Settings",
     *     description="API Endpoints of Settings"
     * )
     
 */

class SettingController extends Controller
{
    // Include the CRUD functions here (index, create, store, show, update, destroy)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/setting/getAllSettings",
      *      operationId="getAllSettings",
      *      tags={"Settings"},
      *      summary="Get list of settings",
      *      description="Returns list of settings",
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/SettingResource")
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
        $Setting = Setting::paginate(10); // Adjust the pagination limit as needed
        return $request->expectsJson()
            ? response()->json(['data' => new SettingResourceCollection($Setting)], Response::HTTP_OK)
            : view('admin.settings.settings', ['settings' => $Setting]);
    }



    public function create()
    {
            return view('admin.settings.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *      path="/setting/addSetting",
      *      operationId="storeSetting",
      *      tags={"Settings"},
      *      summary="Store new setting",
      *      description="Returns setting data",
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/StoreSettingRequest")
      *      ),
      *      @OA\Response(
      *          response=201,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Setting")
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
        $validator = Validations::ValidateSettingStore($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

         $Setting = Setting::create($request->all());
         return response()->json(['data' => $Setting], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/setting/{id}/getSettingById",
      *      operationId="getSettingById",
      *      tags={"Settings"},
      *      summary="Get setting information",
      *      description="Returns setting data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Setting id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Setting")
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
        $Setting = Setting::find($id); // find row by id

        // if row Setting is not found, return 404 and status message
        if (!$Setting) {
           return response()->json(['error' => 'Setting not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $Setting], Response::HTTP_OK);

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
      *      path="/setting/{id}/updateSettingById",
      *      operationId="updateSetting",
      *      tags={"Settings"},
      *      summary="Update existing setting",
      *      description="Returns updated setting data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Setting id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/UpdateSettingRequest")
      *      ),
      *      @OA\Response(
      *          response=202,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Setting")
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
        $validator = Validations::ValidateSettingStore($request);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $Setting = Setting::find($id); // find row by id

        // if row Setting is not found, return 404 and status message
        if (!$Setting) {
           return response()->json(['error' => 'Setting not found'], Response::HTTP_NOT_FOUND);
         }
         $Setting->update($request->all());

         return response()->json(['data' => $Setting], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Delete(
      *      path="/setting/{id}/deleteSettingById",
      *      operationId="deleteSetting",
      *      tags={"Settings"},
      *      summary="Delete existing setting",
      *      description="Deletes a record and returns no content",
      *      @OA\Parameter(
      *          name="id",
      *          description="Setting id",
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
         $Setting = Setting::find($id); // find row by id

         // if row Setting is not found, return 404 and status message
         if (!$Setting) {
            return response()->json(['error' => 'Setting not found'], Response::HTTP_NOT_FOUND);
        }
         $Setting->delete();

         return response()->json(null, Response::HTTP_NO_CONTENT);
        }
}
