<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SwitchTypeResource;
use App\Http\Resources\Api\SwitchUnitResource;
use App\Models\SwitchType;
use App\Models\SwitchUnit;
use Illuminate\Http\JsonResponse;

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
        $switches = collect($switchUnit->switches);
        $switchTypeIds = $switches->pluck('switchType')->unique()->toArray();
        $switchTypes = SwitchType::query()->whereIn('id', $switchTypeIds)->get();

        return response()->json(SwitchTypeResource::collection($switchTypes));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/switch-unit/{switchUnit}/switches/update/status",
     *     operationId="switchesStatusUpdate",
     *     tags={"Switch Unit"},
     *     summary="Update the status of all switches in a switch unit",
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
     *         description="Switches status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Switches status updated successfully"
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
     * @return JsonResponse
     */
    public function switchesStatusUpdate(SwitchUnit $switchUnit): JsonResponse
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

        dd($switchesStatus, $switches->toArray(), $newSwitches);

        return response()->json(['message' => 'Switches status updated successfully']);
    }
}
