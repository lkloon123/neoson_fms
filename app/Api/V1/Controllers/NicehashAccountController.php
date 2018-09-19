<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateNicehashAccountRequest;
use App\Api\V1\Requests\UpdateNicehashAccountRequest;
use App\Api\V1\Resources\NicehashAccountResource;
use App\Helper\ResponseHelper;
use App\Models\NicehashAccount;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NicehashAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all nicehash account by user
        $nicehashAccount = Auth::user()->nicehashAccounts;

        if ($nicehashAccount->isEmpty())
            throw new NotFoundHttpException('no nicehash account found for this user');

        return ResponseHelper::success(NicehashAccountResource::collection($nicehashAccount));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateNicehashAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateNicehashAccountRequest $request)
    {
        $nicehashAccount = NicehashAccount::create([
            'account_name' => $request->get('account_name'),
            'wallet_address' => $request->get('wallet_address'),
            'is_notification_enabled' => $request->get('is_notification_enabled'),
            'user_id' => Auth::user()->id
        ]);

        $this->validateModel($nicehashAccount);

        return ResponseHelper::success([
            'msg' => 'nicehash account created',
            'id' => $nicehashAccount->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $nicehashAccountId
     * @return \Illuminate\Http\Response
     */
    public function show($nicehashAccountId)
    {
        //get all nicehash account by user
        $nicehashAccount = Auth::user()->nicehashAccounts;

        if ($nicehashAccount->isEmpty())
            throw new NotFoundHttpException('no nicehash account found for this user');

        $findNicehashAccount = $nicehashAccount->find($nicehashAccountId);

        if ($findNicehashAccount === null)
            throw new NotFoundHttpException('Nicehash Account id ' . $nicehashAccountId . ' not found');

        return ResponseHelper::success(new NicehashAccountResource($findNicehashAccount));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $nicehashAccountId
     * @param UpdateNicehashAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($nicehashAccountId, UpdateNicehashAccountRequest $request)
    {
        //get all nicehash account by user
        $nicehashAccount = Auth::user()->nicehashAccounts;

        if ($nicehashAccount->isEmpty())
            throw new NotFoundHttpException('no nicehash account found for this user');

        /** @var NicehashAccount $findNicehashAccount */
        $findNicehashAccount = $nicehashAccount->find($nicehashAccountId);

        if ($findNicehashAccount === null)
            throw new NotFoundHttpException('Nicehash Account id ' . $nicehashAccountId . ' not found');

        $requestData = $request->only([
            'account_name', 'wallet_address', 'is_notification_enabled', 'is_notify_once'
        ]);

        foreach ($requestData as $key => $value) {
            $findNicehashAccount->$key = $value;
        }

        $this->saveModel($findNicehashAccount);

        return ResponseHelper::success([
            'msg' => 'nicehash account ' . $findNicehashAccount->account_name . ' updated',
            'id' => $nicehashAccountId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $nicehashAccountId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete($nicehashAccountId)
    {
        //get all nicehash account by user
        $nicehashAccount = Auth::user()->nicehashAccounts;

        if ($nicehashAccount->isEmpty())
            throw new NotFoundHttpException('no nicehash account found for this user');

        /** @var NicehashAccount $findNicehashAccount */
        $findNicehashAccount = $nicehashAccount->find($nicehashAccountId);

        if ($findNicehashAccount === null)
            throw new NotFoundHttpException('Nicehash Account id ' . $nicehashAccountId . ' not found');

        $findNicehashAccount->delete();

        return ResponseHelper::success([
            'msg' => 'nicehash account ' . $findNicehashAccount->account_name . ' deleted'
        ]);
    }
}
