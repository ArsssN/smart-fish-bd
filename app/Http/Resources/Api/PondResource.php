<?php

namespace App\Http\Resources\Api;

use App\Models\SensorType;
use App\Models\SwitchType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PondResource",
 *     title="Pond Resource",
 *     @OA\Property(property="id", type="integer", format="int64", example="1"),
 *     @OA\Property(property="name", type="string", maxLength=180, example="Pond Name"),
 *     @OA\Property(property="slug", type="string", maxLength=191, example="pond-name"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive"}, default="active", example="active"),
 *     @OA\Property(property="address", type="string", example="Pond address"),
 *     @OA\Property(property="description", type="string", example="Pond description"),
 * )
 */
class PondResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pond = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'address' => $this->address,
            'description' => $this->description,
        ];

        if (request()->route()->getName() === 'api.v1.pond.show') {
            $pond['sensor_units'] = SensorUnitResource::collection($this->sensorUnits);
            $pond['switch_units'] = SwitchUnitResource::collection($this->switchUnits);

            $pond['sensor_types'] = SensorTypeResource::collection(SensorType::query()->get());
            $pond['switch_types'] = SwitchTypeResource::collection(SwitchType::query()->get());
        }

        return $pond;
    }
}
