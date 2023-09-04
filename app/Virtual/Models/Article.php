<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Article",
 *     description="Article model",
 *     @OA\Xml(
 *         name="Article"
 *     )
 * )
 */
class Article
{
    /**
     * @OA\Property(
     *     title="title",
     *     description="title of the Article model",
     *     example="",
     * )
     *
     * @var 
     */
    public $title;
    /**
     * @OA\Property(
     *     title="photo_url",
     *     description="photo_url of the Article model",
     *     example="",
     * )
     *
     * @var 
     */
    public $photo_url;
    /**
     * @OA\Property(
     *     title="content",
     *     description="content of the Article model",
     *     example="",
     * )
     *
     * @var 
     */
    public $content;
    /**
     * @OA\Property(
     *     title="published_at",
     *     description="published_at of the Article model",
     *     example="",
     * )
     *
     * @var 
     */
    public $published_at;

}
