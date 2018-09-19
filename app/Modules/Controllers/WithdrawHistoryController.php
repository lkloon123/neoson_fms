<?php

namespace App\Modules\Controllers;

use App\Helper\ResponseHelper;
use App\Models\WithdrawHistory;
use App\Modules\Resources\WithdrawHistoryResource;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WithdrawHistoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all withdraw history by user
        $farms = Auth::user()->farms;
        $withdrawHistories = WithdrawHistory::whereIn('farm_id', $farms->pluck('id'))->get();

        if ($withdrawHistories->isEmpty())
            throw new NotFoundHttpException('no withdraw history found for this user');

        return ResponseHelper::success(WithdrawHistoryResource::collection($withdrawHistories));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawHistory $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawHistory $poolData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawHistory $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\WithdrawHistory $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawHistory $withdrawHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawHistory $withdrawHistory)
    {
        //
    }
}
