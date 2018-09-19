<?php

namespace App\Api\V1\Resources;

/**
 * Class Support
 *
 * @mixin \App\Models\SupportTicket
 * */
class SupportTicketResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'subject' => $this->subject,
            'status' => $this->status,
            'created_by' => new UserResource($this->user),
        ], $this->dateTimeData());
    }
}