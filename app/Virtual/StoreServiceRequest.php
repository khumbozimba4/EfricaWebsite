<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Service request",
 *      description="Store Service request body data",
 *      type="object",
 *      required={"title","description","icon"}
 * )
 */
class StoreServiceRequest
{

    /**
     * @OA\Property(
     *      title="title",
     *      description="title of the new Service",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="description",
     *      description="description of the new Service",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="icon",
     *      description="icon of the new Service",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $icon;

}
