<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SensorResource",
 *     title="Sensor Resource",
 *     description="Represents a sensor resource.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the sensor."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the sensor."
 *     ),
 *     @OA\Property(
 *         property="serial_number",
 *         type="string",
 *         nullable=true,
 *         description="The serial number of the sensor."
 *     ),
 *     @OA\Property(
 *         property="sensor_type",
 *         ref="#/components/schemas/SensorType",
 *         description="The details of the sensor type associated with the sensor."
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="A description of the sensor."
 *     ),
 * )
 */
class SensorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'serial_number' => $this->serial_number,
            'sensor_type' => new SensorTypeResource($this->sensorType),
            'description' => $this->description,
        ];
    }
}
