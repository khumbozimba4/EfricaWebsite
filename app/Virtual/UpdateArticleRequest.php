<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="UpdateArticle request",
 *      description="UpdateArticle request body data",
 *      type="object",
 *      required={"title","photo_url","content","published_at"}
 * )
 */
class UpdateArticleRequest
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
