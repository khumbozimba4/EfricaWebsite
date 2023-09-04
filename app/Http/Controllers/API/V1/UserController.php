<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\UserResourceCollection;
use Illuminate\Http\Response;
use App\Helpers\Validations;

/**
 * @OA\Tag(
     *     name="Users",
     *     description="API Endpoints of Users"
     * )
     
 */

class UserController extends Controller
{
    // Include the CRUD functions here (index, create, store, show, update, destroy)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/user/getAllUsers",
      *      operationId="getAllUsers",
      *      tags={"Users"},
      *      summary="Get list of users",
      *      description="Returns list of users",
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
        $User = User::paginate(10); // Adjust the pagination limit as needed
        return $request->expectsJson()
            ? response()->json(['data' => new UserResourceCollection($User)], Response::HTTP_OK)
            : view('admin.users.users', ['users' => $User]);
    }



    public function create()
    {
            return view('admin.users.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *      path="/user/addUser",
      *      operationId="storeUser",
      *      tags={"Users"},
      *      summary="Store new user",
      *      description="Returns user data",
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
      *      ),
      *      @OA\Response(
      *          response=201,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/User")
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
        $validator = Validations::ValidateUserStore($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

         $User = User::create($request->all());
         return response()->json(['data' => $User], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/user/{id}/getUserById",
      *      operationId="getUserById",
      *      tags={"Users"},
      *      summary="Get user information",
      *      description="Returns user data",
      *      @OA\Parameter(
      *          name="id",
      *          description="User id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/User")
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
        $User = User::find($id); // find row by id

        // if row User is not found, return 404 and status message
        if (!$User) {
           return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $User], Response::HTTP_OK);

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
      *      path="/user/{id}/updateUserById",
      *      operationId="updateUser",
      *      tags={"Users"},
      *      summary="Update existing user",
      *      description="Returns updated user data",
      *      @OA\Parameter(
      *          name="id",
      *          description="User id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
      *      ),
      *      @OA\Response(
      *          response=202,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/User")
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
        $validator = Validations::ValidateUserStore($request);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $User = User::find($id); // find row by id

        // if row User is not found, return 404 and status message
        if (!$User) {
           return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
         }
         $User->update($request->all());

         return response()->json(['data' => $User], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Delete(
      *      path="/user/{id}/deleteUserById",
      *      operationId="deleteUser",
      *      tags={"Users"},
      *      summary="Delete existing user",
      *      description="Deletes a record and returns no content",
      *      @OA\Parameter(
      *          name="id",
      *          description="User id",
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
         $User = User::find($id); // find row by id

         // if row User is not found, return 404 and status message
         if (!$User) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
         $User->delete();

         return response()->json(null, Response::HTTP_NO_CONTENT);
        }
}
