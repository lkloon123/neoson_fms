<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\UpdateNotificationSettingRequest;
use App\Api\V1\Resources\NotificationSettingResource;
use App\Helper\ResponseHelper;
use App\Models\NotificationSetting;
use Auth;

class NotificationSettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notificationSetting = Auth::user()->notificationSetting;

        if ($notificationSetting === null) {
            return ResponseHelper::success(new NotificationSettingResource(NotificationSetting::default()));
        }

        return ResponseHelper::success(new NotificationSettingResource($notificationSetting));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNotificationSettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationSettingRequest $request)
    {
        $notificationSetting = NotificationSetting::updateOrCreate(['user_id' => Auth::user()->id],
            [
                'email_type_alert' => $request->get('email_type_alert'),
                'facebook_type_alert' => $request->get('facebook_type_alert'),
                'telegram_type_alert' => $request->get('telegram_type_alert'),
                'web_type_alert' => $request->get('web_type_alert'),
            ]);

        $this->validateModel($notificationSetting);

        return ResponseHelper::success([
            'msg' => 'user notification setting updated',
            'id' => $notificationSetting->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationSetting $notificationSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationSetting $notificationSetting)
    {
        //
    }
}
