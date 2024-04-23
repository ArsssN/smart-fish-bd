<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="MqttDataHistoryResource",
 *     title="Mqtt Data History Resource",
 *     required={"id", "mqtt_data_id", "sensor_unit_id", "sensor_type_id", "switch_unit_id", "switch_type_id", "value", "message", "created_at"},
 *     @OA\Property(property="id", type="integer", format="int64", description="The unique identifier of the resource"),
 *     @OA\Property(property="mqtt_data_id", type="integer", format="int64", description="The unique identifier of the mqtt data"),
 *     @OA\Property(property="sensor_unit_id", type="integer", format="int64", description="The unique identifier of the sensor unit"),
 *     @OA\Property(property="sensor_type_id", type="integer", format="int64", description="The unique identifier of the sensor type"),
 *     @OA\Property(property="switch_unit_id", type="integer", format="int64", description="The unique identifier of the switch unit"),
 *     @OA\Property(property="switch_type_id", type="integer", format="int64", description="The unique identifier of the switch type"),
 *     @OA\Property(property="value", type="string", description="The value of the resource"),
 *     @OA\Property(property="message", type="string", description="The message of the resource"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="The date and time of the resource created"),
 * )
 */
class MqttDataHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'mqtt_data_id' => $this['mqtt_data_id'],
            'sensor_unit_id' => $this['sensor_unit_id'],
            'sensor_type_id' => $this['sensor_type_id'],
            'switch_unit_id' => $this['switch_unit_id'],
            'switch_type_id' => $this['switch_type_id'],
            'value' => $this['value'],
            'message' => $this['message'],
            'created_at' => $this['created_at'],
        ];
    }
}
