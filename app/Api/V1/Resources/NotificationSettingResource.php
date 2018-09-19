<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Resources;

/**
 * Class NotificationSetting
 *
 * @mixin \App\Models\NotificationSetting
 * */
class NotificationSettingResource extends BaseResource
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
            'email_type_alert' => $this->email_type_alert === 1,
            'telegram_type_alert' => $this->telegram_type_alert === 1,
            'facebook_type_alert' => $this->facebook_type_alert === 1,
            'web_type_alert' => $this->web_type_alert === 1,
        ], $this->dateTimeData());
    }
}