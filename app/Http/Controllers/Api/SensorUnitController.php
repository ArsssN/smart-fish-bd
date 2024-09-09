<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SensorTypeResource;
use App\Http\Resources\Api\SensorUnitResource;
use App\Models\SensorUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class SensorUnitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/sensor-unit/list",
     *     operationId="sensorUnitList",
     *     tags={"Sensor Unit"},
     *     summary="List of sensor units",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of sensors",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SensorUnitResource"),
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
        $sensorUnits = SensorUnit::query()->get();

        return response()->json(SensorUnitResource::collection($sensorUnits));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sensor-unit/{sensorUnit}/sensor-type/list",
     *     operationId="sensorUnitSensorTypeList",
     *     tags={"Sensor Unit"},
     *     summary="List of sensor types for a sensor unit",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="sensorUnit",
     *         in="path",
     *         description="Sensor unit ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of sensor types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SensorType"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * @param SensorUnit $sensorUnit - The sensor unit
     * @return JsonResponse
     */
    public function sensorTypeList(SensorUnit $sensorUnit): JsonResponse
    {
        /*$lastDate = Carbon::make('2024-05-10')->startOfDay();
        $laterDate = Carbon::make('2024-05-10')->endOfDay();*/

        $lastDate = Carbon::now()->subDay();
        $laterDate = Carbon::now();

        $sensorTypes = $sensorUnit->sensorTypes()
            ->withAvg(
                [
                    'mqttDataHistories' => function ($query) use ($laterDate, $lastDate) {
                        $query->whereBetween('created_at', [$lastDate, $laterDate])
                            ->whereNotNull('value')
                            ->where('value', "!=", "");
                    }
                ],
                'value'
            )
            ->with('mqttDataHistory')
            ->get();

        return response()->json(SensorTypeResource::collection($sensorTypes));
    }
}
