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
}
