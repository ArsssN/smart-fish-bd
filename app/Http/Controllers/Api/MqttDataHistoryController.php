<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MqttDataHistoryResource;
use App\Models\Pond;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MqttDataHistoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/project/{project}/pond/{pond}/unit-type/{unitType}/unit/{unitId}/history",
     *      operationId="unitTypeHistory",
     *      tags={"History"},
     *      summary="Get unit type history",
     *      security={{"bearerAuth": {}}},
     *       @OA\Parameter(
     *           name="project",
     *           in="path",
     *           description="Project ID",
     *           required=true,
     *           @OA\Schema(
     *               type="integer",
     *               format="int64"
     *           )
     *       ),
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
     *      @OA\Parameter(
     *          name="unitType",
     *          in="path",
     *          description="Unit Type",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"sensor", "switch"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="unitId",
     *          in="path",
     *          description="Unit ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="typeId",
     *          in="query",
     *          description="Unit Type ID",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          description="Items per page",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              enum={10, 20, 50, 100},
     *              default=10
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Unit type history",
     *          @OA\JsonContent(
     *              @OA\Property(property="current_page", type="integer"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MqttDataHistoryResource")),
     *              @OA\Property(property="first_page_url", type="string"),
     *              @OA\Property(property="from", type="integer"),
     *              @OA\Property(property="last_page", type="integer"),
     *              @OA\Property(property="last_page_url", type="string"),
     *              @OA\Property(
     *                  property="links",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="url", type="string"),
     *                      @OA\Property(property="label", type="string"),
     *                      @OA\Property(property="active", type="boolean"),
     *                  )
     *              ),
     *              @OA\Property(property="next_page_url", type="string"),
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="per_page", type="integer"),
     *              @OA\Property(property="prev_page_url", type="string"),
     *              @OA\Property(property="to", type="integer"),
     *              @OA\Property(property="total", type="integer"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Pond not found",
     *      )
     *  )
     * @param Project $project
     * @param Pond $pond
     * @param $unitType
     * @param null $typeId
     *
     * @return JsonResponse
     */
    public function unitTypeHistory(Project $project, Pond $pond, $unitType, $unitId): JsonResponse
    {
        if (!$project || !$pond) {
            return response()->json([
                'message' => 'Pond or Project not found'
            ], 404);
        }

        $pond = $pond->project_id === $project->id && $pond->project->customer_id === auth()->id() ? $pond : null;

        if (!$pond) {
            return response()->json([
                'message' => 'Pond not found'
            ], 404);
        }

        $perPage = request()->perPage ?? 10;

        $history = $pond->histories()->where("{$unitType}_unit_id", $unitId);
        if (request()->typeId) {
            $history->where("{$unitType}_type_id", request()->typeId);
        }
        $history = $history->paginate($perPage)->toArray();

        $history['data'] = MqttDataHistoryResource::collection($history['data']);

        return response()->json($history);
    }
}
