<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/project/list",
     *     operationId="projectList",
     *     tags={"Project"},
     *     summary="Get all projects",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProjectResource"),
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $projects = auth()->user()->projects()->get();

        return response()->json(ProjectResource::collection($projects));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/project/{project}",
     *     operationId="projectShow",
     *     tags={"Project"},
     *     summary="Get project",
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
     *         description="Project",
     *         @OA\JsonContent(ref="#/components/schemas/ProjectResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found",
     *     )
     * )
     * @param Project $project
     *
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json(new ProjectResource($project));
    }
}
