<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResourceCollection;
use Illuminate\Http\Response;
use App\Helpers\Validations;

/**
 * @OA\Tag(
     *     name="Articles",
     *     description="API Endpoints of Articles"
     * )
     
 */

class ArticleController extends Controller
{
    // Include the CRUD functions here (index, create, store, show, update, destroy)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/article/getAllArticles",
      *      operationId="getAllArticles",
      *      tags={"Articles"},
      *      summary="Get list of articles",
      *      description="Returns list of articles",
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/ArticleResource")
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
        $Article = Article::paginate(10); // Adjust the pagination limit as needed
        return $request->expectsJson()
            ? response()->json(['data' => new ArticleResourceCollection($Article)], Response::HTTP_OK)
            : view('admin.articles.articles', ['articles' => $Article]);
    }



    public function create()
    {
            return view('admin.articles.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *      path="/article/addArticle",
      *      operationId="storeArticle",
      *      tags={"Articles"},
      *      summary="Store new article",
      *      description="Returns article data",
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/StoreArticleRequest")
      *      ),
      *      @OA\Response(
      *          response=201,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Article")
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
        $validator = Validations::ValidateArticleStore($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

         $Article = Article::create($request->all());
         return response()->json(['data' => $Article], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Get(
      *      path="/article/{id}/getArticleById",
      *      operationId="getArticleById",
      *      tags={"Articles"},
      *      summary="Get article information",
      *      description="Returns article data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Article id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Article")
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
        $Article = Article::find($id); // find row by id

        // if row Article is not found, return 404 and status message
        if (!$Article) {
           return response()->json(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $Article], Response::HTTP_OK);

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
      *      path="/article/{id}/updateArticleById",
      *      operationId="updateArticle",
      *      tags={"Articles"},
      *      summary="Update existing article",
      *      description="Returns updated article data",
      *      @OA\Parameter(
      *          name="id",
      *          description="Article id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\RequestBody(
      *          required=true,
      *          @OA\JsonContent(ref="#/components/schemas/UpdateArticleRequest")
      *      ),
      *      @OA\Response(
      *          response=202,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/Article")
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
        $validator = Validations::ValidateArticleStore($request);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $Article = Article::find($id); // find row by id

        // if row Article is not found, return 404 and status message
        if (!$Article) {
           return response()->json(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
         }
         $Article->update($request->all());

         return response()->json(['data' => $Article], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Delete(
      *      path="/article/{id}/deleteArticleById",
      *      operationId="deleteArticle",
      *      tags={"Articles"},
      *      summary="Delete existing article",
      *      description="Deletes a record and returns no content",
      *      @OA\Parameter(
      *          name="id",
      *          description="Article id",
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
         $Article = Article::find($id); // find row by id

         // if row Article is not found, return 404 and status message
         if (!$Article) {
            return response()->json(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }
         $Article->delete();

         return response()->json(null, Response::HTTP_NO_CONTENT);
        }
}
