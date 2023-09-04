<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Service",
 *     description="Service model",
 *     @OA\Xml(
 *         name="Service"
 *     )
 * )
 */
class Service
{
    /**
     * @OA\Property(
     *     title="title",
     *     description="title of the Service model",
     *     example="",
     * )
     *
     * @var 
     */
    public $title;
    /**
     * @OA\Property(
     *     title="description",
     *     description="description of the Service model",
     *     example="",
     * )
     *
     * @var 
     */
    public $description;
    /**
     * @OA\Property(
     *     title="icon",
     *     description="icon of the Service model",
     *     example="",
     * )
     *
     * @var 
     */
    public $icon;

}
