<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SensorUnitResource",
 *     required={"id", "name", "serial_number", "slug", "description", "status"},
 *     @OA\Property(property="id", type="integer", format="int64", description="The unique identifier of the resource"),
 *     @OA\Property(property="name", type="string", description="The name of the resource"),
 *     @OA\Property(property="serial_number", type="string", description="The serial number of the resource"),
 *     @OA\Property(property="slug", type="string", description="The slug of the resource"),
 *     @OA\Property(property="description", type="string", description="The description of the resource"),
 *     @OA\Property(property="status", type="string", description="The status of the resource"),
 * )
 */
class SensorUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sensorUnit = [
            'id' => $this->id,
            'name' => $this->name,
            'serial_number' => $this->serial_number,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
        ];

        return $sensorUnit;
    }
}
