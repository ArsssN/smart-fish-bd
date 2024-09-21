<?php

namespace App\Http\Resources\Api;

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @OA\Schema(
 *     schema="SwitchUnitResource",
 *     title="Switch Unit Resource",
 *     required={"id", "name", "slug", "description", "status", "switches"},
 *     @OA\Property(property="id", type="integer", format="int64", description="The unique identifier of the resource"),
 *     @OA\Property(property="name", type="string", description="The name of the resource"),
 *     @OA\Property(property="slug", type="string", description="The slug of the resource"),
 *     @OA\Property(property="description", type="string", description="The description of the resource"),
 *     @OA\Property(property="status", type="string", description="The status of the resource"),
 *     @OA\Property(property="switches", type="array", description="Array of switches",
 *         @OA\Items(type="string", description="Switches", ref="#/components/schemas/Switch"),
 *     ),
 * )
 */
class SwitchUnitResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Switch",
     *     required={"number", "switchType", "status"},
     *     @OA\Property(property="number", type="string", description="The number of the switch"),
     *     @OA\Property(property="switchType", type="string", description="The type of the switch"),
     *     @OA\Property(property="status", type="string", description="The status of the switch (e.g., on/off)"),
     *     @OA\Property(property="comment", type="string", nullable=true, description="Additional comment about the switch"),
     *     @OA\Property(property="run_time", type="string", nullable=false, description="The runtime of the switch"),
     * )
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|Arrayable|JsonSerializable
     * @throws Exception
     */
    public function toArray($request)
    {
        $switches = $this->history->switchUnitHistoryDetails->map(function ($switchUnitHistoryDetail) {
            $run_time = $switchUnitHistoryDetail->run_time ?? 0;
            return [
                'number' => $switchUnitHistoryDetail->number,
                'switchType' => $switchUnitHistoryDetail->switch_type_id,
                'status' => $switchUnitHistoryDetail->status,
                'comment' => $switchUnitHistoryDetail->comment,
                'run_time' => $run_time ? CarbonInterval::second($run_time)->cascade()->forHumans(['short' => true]) : '',
            ];
        });

        $switchUnit = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'switches' => $switches,
        ];

        return $switchUnit;
    }
}
