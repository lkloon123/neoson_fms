<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateSupportTicketRequest;
use App\Api\V1\Requests\UpdateSupportTicketRequest;
use App\Api\V1\Resources\SupportTicketResource;
use App\Helper\ResponseHelper;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Auth;
use Bouncer;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupportTicketController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all support by user
        $supportTickets = Auth::user()->supportTickets->sortByDesc('created_at');

        if (Bouncer::can('see_all_support_ticket')) {
            $supportTickets = SupportTicket::all()->sortByDesc('created_at');
        }

        /** @var Collection $supportTickets */
        if ($supportTickets->isEmpty())
            throw new NotFoundHttpException('no support ticket found for this user');

        return ResponseHelper::success(SupportTicketResource::collection($supportTickets));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateSupportTicketRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateSupportTicketRequest $request)
    {
        $supportTicket = SupportTicket::create([
            'subject' => $request->get('subject'),
            'user_id' => Auth::user()->id,
        ]);

        $this->validateModel($supportTicket);

        $supportTicketMessage = SupportTicketMessage::create([
            'message' => $request->get('message'),
            'post_by_user_id' => Auth::user()->id,
            'support_ticket_id' => $supportTicket->id,
        ]);

        $this->validateModel($supportTicketMessage);

        return ResponseHelper::success([
            'msg' => 'support ticket created',
            'id' => $supportTicket->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $supportTicketId
     * @return \Illuminate\Http\Response
     */
    public function show($supportTicketId)
    {
        $supportTicket = Auth::user()
            ->supportTickets
            ->where('id', '=', $supportTicketId)
            ->first();

        if (Bouncer::can('see_all_support_ticket')) {
            $supportTicket = SupportTicket::whereId($supportTicketId)->first();
        }

        if ($supportTicket === null)
            throw new NotFoundHttpException('support ticket id #' . $supportTicketId . ' not found');

        return ResponseHelper::success(new SupportTicketResource($supportTicket));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $supportTicketId
     * @param UpdateSupportTicketRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($supportTicketId, UpdateSupportTicketRequest $request)
    {
        /** @var SupportTicket $support */
        $supportTicket = Auth::user()
            ->supportTickets
            ->where('id', '=', $supportTicketId)
            ->first();

        if (Bouncer::can('see_all_support_ticket')) {
            $supportTicket = SupportTicket::whereId($supportTicketId)->first();
        }

        if ($supportTicket === null)
            throw new NotFoundHttpException('support ticket id #' . $supportTicketId . ' not found');

        $supportTicket->status = $request->get('status');

        $this->saveModel($supportTicket);

        return ResponseHelper::success([
            'msg' => 'support ticket updated',
            'id' => $supportTicketId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupportTicket $support
     * @return \Illuminate\Http\Response
     */
    public function delete(SupportTicket $support)
    {
        //
    }
}
