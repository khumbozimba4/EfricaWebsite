<?php
namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="ServiceResource",
 *     description="Service resource",
 *     @OA\Xml(
 *         name="ServiceResource"
 *     )
 * )
 */
class ServiceResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Service[]
     */
    private $data;
}
