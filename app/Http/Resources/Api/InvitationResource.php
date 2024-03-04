<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
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
            'code'       => $this->code,
            //'event'      => EventResource::make($this->event),
            //'invitee' => $this->invitee,
            'send_sms'   => $this->sendSms,
            'send_email' => $this->sendEmail,
        ];
    }
}
