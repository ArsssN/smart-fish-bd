<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SensorTypeResource;
use App\Models\Sensor;
use App\Models\SensorType;
use Illuminate\Http\JsonResponse;

class SensorTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/sensor-type/list",
     *     operationId="sensorTypeList",
     *     tags={"Sensor Type"},
     *     summary="List of sensor types",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of sensors",
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
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $sensorTypes = SensorType::query()->get();

        return response()->json(SensorTypeResource::collection($sensorTypes));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sensor-type/feedback/{sensor}/{value}",
     *     operationId="sensorTypeFeedback",
     *     tags={"Sensor Type"},
     *     summary="Sensor type feedback",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="sensor",
     *         in="path",
     *         description="Sensor ID: <br/>- 1: Oxygen Sensor<br/>- 2: TDS Sensor<br/>- 3: Temperature Sensor <br/>-
              4: PH Sensor", required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"1", "2", "3", "4"},
     *             default="1",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="value",
     *         in="path",
     *         description="Sensor value",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sensor feedback",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Response from sensor",
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function sensorFeedback(Sensor $sensor, int $value): JsonResponse
    {
        $sensorType = $sensor->sensorType;

        $sensorName = str_replace(' ', '', $sensorType->name);
        $helperMethodName = "get{$sensorName}Update";

        if (function_exists($helperMethodName)) {
            $sensor_message = ($helperMethodName($value));
        } else {
            $sensor_message = "Invalid sensor type";
        }

        return response()->json([
            'message' => $sensor_message,
        ]);
    }
}
