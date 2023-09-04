<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Article request",
 *      description="Store Article request body data",
 *      type="object",
 *      required={"title","photo_url","content","published_at"}
 * )
 */
class StoreArticleRequest
{

    /**
     * @OA\Property(
     *      title="title",
     *      description="title of the new Article",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="photo_url",
     *      description="photo_url of the new Article",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $photo_url;

    /**
     * @OA\Property(
     *      title="content",
     *      description="content of the new Article",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $content;

    /**
     * @OA\Property(
     *      title="published_at",
     *      description="published_at of the new Article",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $published_at;

}
