<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\UpdateNotificationRequest;
use App\Api\V1\Resources\NotificationResource;
use App\Helper\ResponseHelper;
use App\Models\Notification;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all notification by user
        $notifications = Auth::user()
            ->notifications
            ->sortByDesc('created_at')
            ->take(10);

        if ($notifications->isEmpty())
            throw new NotFoundHttpException('no notification found for this user');

        return ResponseHelper::success(NotificationResource::collection($notifications));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $notificationId
     * @param UpdateNotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($notificationId, UpdateNotificationRequest $request)
    {
        //find for notification
        $notification = Notification::find($notificationId);

        if ($notification === null) {
            throw new NotFoundHttpException('notification id ' . $notification . ' not found');
        }

        $notification->update([
            'is_read' => $request->get('is_read')
        ]);

        return ResponseHelper::success([
            'msg' => 'notification updated',
            'id' => $notificationId
        ]);
    }

    public function updateAll(UpdateNotificationRequest $request)
    {
        //find for notification
        $unreadNotificationList = Notification::all()->where('is_read', '=', false)->all();

        if ($unreadNotificationList !== null) {
            foreach ($unreadNotificationList as $notification) {
                /** @var Notification $notification */
                $notification->update([
                    'is_read' => $request->get('is_read')
                ]);
            }
        }

        return ResponseHelper::success([
            'msg' => 'all notification updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function delete(Notification $notification)
    {
        //
    }
}
