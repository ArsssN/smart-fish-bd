<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProjectResource",
 *     title="Project Resource",
 *     @OA\Property(property="id", type="integer", format="int64", example="1"),
 *     @OA\Property(property="name", type="string", maxLength=180, example="Project Name"),
 *     @OA\Property(property="slug", type="string", maxLength=191, example="project-name"),
 *     @OA\Property(property="description", type="string", example="Project description"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive"}, default="active", example="active"),
 * )
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $project = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status
        ];

        if (request()->route()->getName() === 'api.v1.project.show') {
            $project['ponds'] = PondResource::collection($this->ponds);
        }

        return $project;
    }
}
