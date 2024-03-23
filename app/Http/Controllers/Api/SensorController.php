<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SensorResource;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;

class SensorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/sensor/list",
     *     operationId="sensorList",
     *     tags={"Sensor"},
     *     summary="List of sensors",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of sensors",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SensorResource"),
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
        /*$sensors = Sensor::query()->whereHas(
            'sensorType',
            function ($query) {
                $query->where('status', 'active');
            }
        )->where(
            'status',
            'active'
        )->get();*/
        $sensors = auth()->user()->sensors()->get();

        return response()->json(
            SensorResource::collection($sensors)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sensor/feedback/{sensor}/{value}",
     *     operationId="sensorFeedback",
     *     tags={"Sensor"},
     *     summary="Sensor feedback",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="sensor",
     *         in="path",
     *         description="Sensor ID: <br/>- 1: Oxygen Sensor - 1<br/>- 2: TDS Sensor - 1<br/>- 3: Temperature Sensor
     *         - 1<br/>- 4: PH
    Sensor - 1", required=true,
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
     *             @OA\Property(property="message", type="string"),
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
