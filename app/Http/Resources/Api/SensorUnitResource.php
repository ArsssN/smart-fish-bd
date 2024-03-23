<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

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
