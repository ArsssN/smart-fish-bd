<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SensorType",
 *     title="Sensor Type",
 *     type="object",
 *     description="Represents a sensor type.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the sensor type."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the sensor type."
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="The slug of the sensor type."
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="A description of the sensor type."
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"active", "inactive"},
 *         default="active",
 *         description="The status of the sensor type."
 *     )
 * )
 */
class SensorTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug, // Add this line
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
