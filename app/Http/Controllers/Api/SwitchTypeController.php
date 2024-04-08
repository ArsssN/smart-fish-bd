<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SwitchTypeResource;
use App\Models\SwitchModel;
use App\Models\SwitchType;
use Illuminate\Http\JsonResponse;

class SwitchTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/switch-type/list",
     *     operationId="switchTypeList",
     *     tags={"Switch Type"},
     *     summary="List of switch types",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of switchs",
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
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $switchTypes = SwitchType::query()->get();

        return response()->json(SwitchTypeResource::collection($switchTypes));
    }
}
