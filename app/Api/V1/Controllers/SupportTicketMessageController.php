<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateSupportTicketMessageRequest;
use App\Api\V1\Resources\SupportTicketMessageResource;
use App\Helper\NotificationHelper;
use App\Helper\ResponseHelper;
use App\Models\Notification;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Auth;
use Bouncer;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupportTicketMessageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param $supportTicketId
     * @return \Illuminate\Http\Response
     */
    public function index($supportTicketId)
    {
        $supportTicket = Auth::user()
            ->supportTickets
            ->where('id', '=', $supportTicketId)
            ->first();

        if (Bouncer::can('see_all_support_ticket')) {
            $supportTicket = SupportTicket::whereId($supportTicketId)->first();
        }

        /** @var SupportTicket $supportTicket */
        if ($supportTicket === null)
            throw new NotFoundHttpException('ticket id #' . $supportTicketId . ' not found');

        $supportMessages = $supportTicket->supportTicketMessages()->get();

        return ResponseHelper::success(SupportTicketMessageResource::collection($supportMessages));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $supportTicketId
     * @param CreateSupportTicketMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($supportTicketId, CreateSupportTicketMessageRequest $request)
    {
        $supportTicket = Auth::user()
            ->supportTickets
            ->where('id', '=', $supportTicketId)
            ->first();

        if (Bouncer::can('see_all_support_ticket')) {
            $supportTicket = SupportTicket::whereId($supportTicketId)->first();

            $supportTicket->update([
                'status' => 'staff replied'
            ]);

            $notification = new Notification([
                'subject' => 'ticket #' . $supportTicketId . ' has been updated',
                'type' => 'support',
                'action_link' => '/portal/support/ticket/view/' . $supportTicketId,
                'user_id' => $supportTicket->user->id
            ]);

            NotificationHelper::send($notification);
        }

        /** @var SupportTicket $supportTicket */
        if ($supportTicket === null)
            throw new NotFoundHttpException('ticket id #' . $supportTicketId . ' not found');

        $supportTicketMessage = SupportTicketMessage::create([
            'message' => $request->get('message'),
            'post_by_user_id' => Auth::user()->id,
            'support_ticket_id' => $supportTicket->id,
        ]);

        if (!Bouncer::can('see_all_support_ticket')) {
            $supportTicket->update([
                'status' => 'user replied'
            ]);
        }

        $this->validateModel($supportTicketMessage);

        return ResponseHelper::success([
            'msg' => 'support ticket message created',
            'id' => $supportTicketMessage->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupportTicketMessage $supportMessage
     * @return \Illuminate\Http\Response
     */
    public function show(SupportTicketMessage $supportMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SupportTicketMessage $supportMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportTicketMessage $supportMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupportTicketMessage $supportMessage
     * @return \Illuminate\Http\Response
     */
    public function delete(SupportTicketMessage $supportMessage)
    {
        //
    }
}
