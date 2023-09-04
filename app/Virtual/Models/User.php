<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="name of the User model",
     *     example="",
     * )
     *
     * @var 
     */
    public $name;
    /**
     * @OA\Property(
     *     title="email",
     *     description="email of the User model",
     *     example="",
     * )
     *
     * @var 
     */
    public $email;
    /**
     * @OA\Property(
     *     title="password",
     *     description="password of the User model",
     *     example="",
     * )
     *
     * @var 
     */
    public $password;

}
