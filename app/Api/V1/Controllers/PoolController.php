<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreatePoolRequest;
use App\Api\V1\Requests\UpdatePoolRequest;
use App\Api\V1\Resources\PoolResource;
use App\Helper\ResponseHelper;
use App\Models\Pool;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PoolController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pools = Pool::all();
        return ResponseHelper::success(PoolResource::collection($pools));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreatePoolRequest $request)
    {
        //check permission
        if (Bouncer::cannot('pool_create')) {
            throw new AccessDeniedHttpException('you are not allow to create pool');
        }

        $requestData = $request->only([
            'pool_name',
            'pool_stratum',
            'pool_api',
            'pool_url',
            'available',
            'type',
            'ticker',
            'algo',
            'port'
        ]);

        $pool = Pool::create($requestData);
        $this->validateModel($pool);

        return ResponseHelper::success([
            'msg' => 'pool created',
            'id' => $pool->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $poolId
     * @return \Illuminate\Http\Response
     */
    public function show($poolId)
    {
        $pool = Pool::find($poolId);
        if ($pool === null)
            throw new NotFoundHttpException('pool id ' . $poolId . ' not found');

        return ResponseHelper::success(new PoolResource($pool));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $poolId
     * @param UpdatePoolRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($poolId, UpdatePoolRequest $request)
    {
        //check permission
        if (Bouncer::cannot('pool_update')) {
            throw new AccessDeniedHttpException('you are not allow to update pool');
        }

        $requestData = $request->only([
            'pool_name',
            'pool_stratum',
            'pool_api',
            'pool_url',
            'available',
            'type',
            'ticker',
            'algo',
            'port'
        ]);

        if (empty($requestData)) {
            return ResponseHelper::success([
                'msg' => 'nothing updated'
            ]);
        }

        //find for pool
        $pool = Pool::find($poolId);

        if ($pool === null) {
            throw new NotFoundHttpException('pool id ' . $poolId . ' not found');
        }

        foreach ($requestData as $key => $value) {
            $pool->$key = $value;
        }

        $this->saveModel($pool);

        return ResponseHelper::success([
            'msg' => 'pool ' . $pool->pool_name . ' updated',
            'id' => $poolId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $poolId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($poolId)
    {
        //check permission
        if (Bouncer::cannot('pool_delete')) {
            throw new AccessDeniedHttpException('you are not allow to delete pool');
        }

        $pool = Pool::find($poolId);
        if ($pool === null)
            throw new NotFoundHttpException('pool id ' . $poolId . ' not found');

        $pool->delete();

        return ResponseHelper::success([
            'msg' => 'pool ' . $pool->pool_name . ' deleted'
        ]);
    }
}
