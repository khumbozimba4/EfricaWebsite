<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Setting",
 *     description="Setting model",
 *     @OA\Xml(
 *         name="Setting"
 *     )
 * )
 */
class Setting
{
    /**
     * @OA\Property(
     *     title="key",
     *     description="key of the Setting model",
     *     example="",
     * )
     *
     * @var 
     */
    public $key;
    /**
     * @OA\Property(
     *     title="value",
     *     description="value of the Setting model",
     *     example="",
     * )
     *
     * @var 
     */
    public $value;

}
