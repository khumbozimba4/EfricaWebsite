<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Setting request",
 *      description="Store Setting request body data",
 *      type="object",
 *      required={"key","value"}
 * )
 */
class StoreSettingRequest
{

    /**
     * @OA\Property(
     *      title="key",
     *      description="key of the new Setting",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $key;

    /**
     * @OA\Property(
     *      title="value",
     *      description="value of the new Setting",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $value;

}
