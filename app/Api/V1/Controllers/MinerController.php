<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateMinerRequest;
use App\Api\V1\Requests\UpdateMinerRequest;
use App\Api\V1\Resources\MinerResource;
use App\Helper\ResponseHelper;
use App\Models\Miner;
use Auth;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Token;

class MinerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $farms = Auth::user()->farms;
        $miners = Miner::whereIn('farm_id', $farms->pluck('id'))->get();

        if ($miners->isEmpty())
            throw new NotFoundHttpException('no miner found for this user');

        return ResponseHelper::success(MinerResource::collection($miners));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateMinerRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function create(CreateMinerRequest $request)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $request->get('farm_id') . '_update')) {
            throw new AccessDeniedHttpException('you are not allow to create miner');
        }

        $requestData = $request->only([
            'miner_name',
            'farm_id',
            'available'
        ]);
        $requestData = array_add($requestData, 'api_token', Token::unique('miners', 'api_token', 40));

        $miner = Miner::create($requestData);
        $this->validateModel($miner);

        return ResponseHelper::success([
            'msg' => 'miner created',
            'id' => $miner->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $minerId
     * @return \Illuminate\Http\Response
     */
    public function show($minerId)
    {
        $farms = Auth::user()->farms;
        $miners = Miner::whereIn('farm_id', $farms->pluck('id'));

        if ($miners->get()->isEmpty()) {
            throw new NotFoundHttpException('no miner found for this user');
        }

        $findMiner = $miners->find($minerId);

        if ($findMiner === null)
            throw new NotFoundHttpException('miner id ' . $minerId . ' not found');

        return ResponseHelper::success(new MinerResource($findMiner));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $minerId
     * @param UpdateMinerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($minerId, UpdateMinerRequest $request)
    {
        $miner = Miner::find($minerId);

        if ($miner === null) {
            throw new NotFoundHttpException('miner id ' . $minerId . ' not found');
        }

        //check permission
        if (Bouncer::cannot('farm_' . $miner->farm_id . '_update')) {
            throw new AccessDeniedHttpException('you are not allow to update this miner');
        }

        $requestData = $request->only([
            'miner_name',
            'farm_id',
            'current_mining_wallet_id',
            'is_notification_enabled',
            'available'
        ]);

        if (empty($requestData)) {
            return ResponseHelper::success([
                'msg' => 'nothing updated'
            ]);
        }

        foreach ($requestData as $key => $value) {
            $miner->$key = $value;
        }

        $this->saveModel($miner);

        return ResponseHelper::success([
            'msg' => 'miner ' . $miner->miner_name . ' updated',
            'id' => $minerId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $minerId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete($minerId)
    {
        $miner = Miner::find($minerId);

        if ($miner === null) {
            throw new NotFoundHttpException('miner id ' . $minerId . ' not found');
        }

        //check permission
        if (Bouncer::cannot('farm_' . $miner->farm_id . '_update')) {
            throw new AccessDeniedHttpException('you are not allow to delete this miner');
        }

        $miner->delete();

        return ResponseHelper::success([
            'msg' => 'miner ' . $miner->miner_name . ' deleted'
        ]);
    }
}
