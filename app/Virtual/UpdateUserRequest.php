<?php
namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="UpdateUser request",
 *      description="UpdateUser request body data",
 *      type="object",
 *      required={"name","email","password"}
 * )
 */
class UpdateUserRequest
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
