<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MqttCommandController;
use App\Http\Resources\Api\SwitchTypeResource;
use App\Http\Resources\Api\SwitchUnitResource;
use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\Pond;
use App\Models\SwitchType;
use App\Models\SwitchUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;

class SwitchUnitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/switch-unit/list",
     *     operationId="switchUnitList",
     *     tags={"Switch Unit"},
     *     summary="List of switch units",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of switchs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SwitchUnitResource"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $switchUnits = SwitchUnit::query()->get();

        return response()->json(SwitchUnitResource::collection($switchUnits));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/switch-unit/{switchUnit}",
     *     operationId="getSwitchUnit",
     *     tags={"Switch Unit"},
     *     summary="Retrieve the details of a specific switch unit",
     *     description="Returns the details of the specified switch unit.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="switchUnit",
     *         in="path",
     *         description="Switch unit ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Switch unit retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SwitchUnitResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Switch unit not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function switchUnit(SwitchUnit $switchUnit): JsonResponse
    {
        return response()->json(new SwitchUnitResource($switchUnit));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/switch-unit/{switchUnit}/switch-type/list",
     *     operationId="switchUnitSwitchTypeList",
     *     tags={"Switch Unit"},
     *     summary="List of switch types for a switch unit",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="switchUnit",
     *         in="path",
     *         description="Switch unit ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of switch types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SwitchType"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * @param SwitchUnit $switchUnit - The switch unit
     * @return JsonResponse
     */
    public function switchTypeList(SwitchUnit $switchUnit): JsonResponse
    {
        $switches = collect($switchUnit->switches ?? []);
        $switchTypeIds = $switches->pluck('switchType')->unique()->toArray();
        $switchTypes = SwitchType::query()->whereIn('id', $switchTypeIds)->get();

        return response()->json(SwitchTypeResource::collection($switchTypes));
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/switch-unit/{switchUnit}/pond/{pond}/switches/update/status",
     *     operationId="switchesStatusUpdate",
     *     tags={"Switch Unit"},
     *     summary="Update the status of all switches in a switch unit",
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="pond",
     *          in="path",
     *          description="Pond ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="switchUnit",
     *         in="path",
     *         description="Switch unit ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="switchesStatus",
     *                 type="array",
     *                 description="Array of statuses for the switches (0 for off, 1 for on)",
     *                 @OA\Items(
     *                     type="integer",
     *                     enum={0, 1}
     *                 ),
     *                 example={1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Switches status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Switches status updated successfully"
     *             ),
     *             @OA\Property(
     *                 property="switchUnit",
     *                 type="object",
     *                 ref="#/components/schemas/SwitchUnitResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * @param SwitchUnit $switchUnit - The switch unit
     * @param Pond $pond - The pond
     * @return JsonResponse
     */
    public function switchesStatusUpdate(SwitchUnit $switchUnit, Pond $pond): JsonResponse
    {
        //$defaultStitchesStatus = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
        $defaultStitchesStatus = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $switchesStatus = request()->switchesStatus ?? $defaultStitchesStatus;
        $switches = collect($switchUnit->switches ?? [])->keyBy('number');

        $newSwitches = array_map(
            function ($switchStatus, $index) use ($switches) {
                $switch = $switches[$index + 1];
                $switch['status'] = $switchStatus === 1 ? 'on' : 'off';

                return $switch;
            },
            $switchesStatus,
            array_keys($switchesStatus)
        );

        $switchUnit->switches = $newSwitches;
        $switchUnit->save();

        try {
            $mqttData = MqttData::query()
                ->whereHas(
                    'switchUnitHistories',
                    function ($query) use ($switchUnit, $pond) {
                        return $query->where([
                            'switch_unit_id' => $switchUnit->id,
                            'pond_id' => $pond->id,
                        ]);
                    }
                )
                ->latest()
                ->first();
            $topic = $mqttData?->publish_topic ?? '';

            MqttCommandController::$feedBackArray = $mqttData?->publish_message
                ? json_decode($mqttData?->publish_message, true)
                : MqttCommandController::$feedBackArray;
            MqttCommandController::$feedBackArray['relay'] = implode('', $switchesStatus);
            MQTT::publish($topic, json_encode(MqttCommandController::$feedBackArray));
            Log::info("Switches status updated successfully on topic [$topic]: " . MqttCommandController::$feedBackArray['relay']);
            $res = [
                'message' => 'Switches status updated successfully',
                'switchUnit' => new SwitchUnitResource($switchUnit)
            ];
        } catch (\Exception $e) {
            $currentDateTime = now()->format('Y-m-d H:i:s');
            Log::info("Tries to update switches status on topic [$topic]: " . MqttCommandController::$feedBackArray['relay']);
            Log::error($e->getMessage());
            echo sprintf('[%s] %s', $currentDateTime, $e->getMessage());
            $res = [
                'message' => 'Failed to update switches status',
                'error' => $e->getMessage()
            ];
        }

        return response()->json($res);
    }
}
