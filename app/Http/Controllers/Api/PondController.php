<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PondResource;
use App\Models\Pond;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PondController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/project/{project}/pond/list",
     *     operationId="pondList",
     *     tags={"Pond"},
     *     summary="Get all ponds",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="project",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of ponds",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PondResource"),
     *         )
     *     )
     * )
     * @param Project $project
     *
     * @return JsonResponse
     */
    public function list(Project $project): JsonResponse
    {
        $ponds = auth()->user()->projects()->where('id', $project->id)->with('ponds')->first()->ponds;

        return response()->json(PondResource::collection($ponds));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/project/{project}/pond/{pond}",
     *     operationId="pondShow",
     *     tags={"Pond"},
     *     summary="Get pond",
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="project",
     *          in="path",
     *          description="Project ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="pond",
     *         in="path",
     *         description="Pond ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pond",
     *         @OA\JsonContent(ref="#/components/schemas/PondResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pond not found",
     *     )
     * )
     * @param Project $project
     * @param Pond $pond
     *
     * @return JsonResponse
     */
    public function show(Project $project, Pond $pond): JsonResponse
    {
        return response()->json(new PondResource($pond));
    }
}
