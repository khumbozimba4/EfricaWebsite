<?php
namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="SettingResource",
 *     description="Setting resource",
 *     @OA\Xml(
 *         name="SettingResource"
 *     )
 * )
 */
class SettingResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Setting[]
     */
    private $data;
}
