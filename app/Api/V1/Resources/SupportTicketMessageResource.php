<?php

namespace App\Api\V1\Resources;

/**
 * Class SupportMessage
 *
 * @mixin \App\Models\SupportTicketMessage
 * */
class SupportTicketMessageResource extends BaseResource
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
            'message' => $this->message,
            'post_by' => new UserResource($this->postBy),
        ], $this->dateTimeData());
    }
}