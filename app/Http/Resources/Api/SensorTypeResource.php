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
 *     ),
 *     @OA\Property(
 *         property="avg",
 *         type="string",
 *         description="The average value of last 24hrs."
 *     ),
 *     @OA\Property(
 *         property="original_value",
 *         type="string",
 *         description="The latest value of mqtt data history",
 *     ),
 *     @OA\Property(
 *         property="value",
 *         type="string",
 *         description="The latest modified value of mqtt data history",
 *     ),
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
            'avg' => number_format(+$this->avg ?? 0, 2),
            'original_value' => $this?->mqttDataHistory?->value ?? '',
            'value' => $this?->mqttDataHistory?->value ? (string)getModifiedMqttDataHistoryValue($this->mqttDataHistory) : ''
        ];
    }
}
