<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "title"       => $this->title,
            "slug"        => $this->slug,
            "description" => $this->description,
            "start_date"  => $this->start_date->format('Y-m-d h:ia'),
            "end_date"    => $this->end_date->format('Y-m-d h:ia'),
            "location"    => $this->location,
            "banner"      => $this->banner,
            // "card_details" => $this->card_details,
            "is_active"   => $this->is_active,
            "status"      => $this->status,
        ];
    }
}
