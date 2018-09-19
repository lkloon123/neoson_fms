<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateCoinRequest;
use App\Api\V1\Requests\UpdateCoinRequest;
use App\Api\V1\Resources\CoinResource;
use App\Helper\ResponseHelper;
use App\Models\Coin;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoinController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::all();
        return ResponseHelper::success(CoinResource::collection($coins));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateCoinRequest $request)
    {
        //check permission
        if (Bouncer::cannot('coin_create')) {
            throw new AccessDeniedHttpException('you are not allow to create coin');
        }

        $requestData = $request->only([
            'coin_name',
            'coin_ticker',
            'coin_algo',
            'isMineable',
            'explorer_link',
            'explorer_type',
            'available'
        ]);

        $coin = Coin::create($requestData);
        $this->validateModel($coin);

        return ResponseHelper::success([
            'msg' => 'coin created',
            'id' => $coin->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $coinId
     * @return \Illuminate\Http\Response
     */
    public function show($coinId)
    {
        $coin = Coin::find($coinId);
        if ($coin === null)
            throw new NotFoundHttpException('coin id ' . $coinId . ' not found');

        return ResponseHelper::success(new CoinResource($coin));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $coinId
     * @param UpdateCoinRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($coinId, UpdateCoinRequest $request)
    {
        //check permission
        if (Bouncer::cannot('coin_update')) {
            throw new AccessDeniedHttpException('you are not allow to update coin');
        }

        $requestData = $request->only([
            'coin_name',
            'coin_ticker',
            'coin_algo',
            'isMineable',
            'explorer_link',
            'explorer_type',
            'available'
        ]);

        if (empty($requestData)) {
            return ResponseHelper::success([
                'msg' => 'nothing updated'
            ]);
        }

        //find for pool
        $coin = Coin::find($coinId);

        if ($coin === null) {
            throw new NotFoundHttpException('coin id ' . $coinId . ' not found');
        }

        foreach ($requestData as $key => $value) {
            $coin->$key = $value;
        }

        $this->saveModel($coin);

        return ResponseHelper::success([
            'msg' => 'coin ' . $coin->coin_name . ' updated',
            'id' => $coinId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $coinId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete($coinId)
    {
        //check permission
        if (Bouncer::cannot('coin_delete')) {
            throw new AccessDeniedHttpException('you are not allow to delete coin');
        }

        $coin = Coin::find($coinId);

        if ($coin === null) {
            throw new NotFoundHttpException('coin id ' . $coinId . ' not found');
        }

        $coin->delete();

        return ResponseHelper::success([
            'msg' => 'coin ' . $coin->coin_name . ' deleted'
        ]);
    }
}
