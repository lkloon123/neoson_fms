<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Resources;

/**
 * Class Notification
 *
 * @mixin \App\Models\Notification
 * */
class NotificationResource extends BaseResource
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
            'type' => $this->type,
            'action_link' => $this->action_link,
            'is_read' => $this->is_read === 1,
        ], $this->dateTimeData());
    }
}