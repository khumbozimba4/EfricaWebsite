<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 *      type="object",
 *      required={"name","email","password"}
 * )
 */
class StoreUserRequest
{

    /**
     * @OA\Property(
     *      title="name",
     *      description="name of the new User",
     *      example="John Doe"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="email of the new User",
     *      example="johndoe@example.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="password of the new User",
     *      example="Your example value here"
     * )
     *
     * @var string
     */
    public $password;

}
