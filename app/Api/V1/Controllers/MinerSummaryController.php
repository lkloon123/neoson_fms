<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateMinerSummaryRequest;
use App\Api\V1\Resources\CoinResource;
use App\Api\V1\Resources\MinerSummaryResource;
use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\Miner;
use App\Models\MinerSummary;
use App\Models\SoftwareUsage;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MinerSummaryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($minerId)
    {
        $farms = Auth::user()->farms;
        $miners = Miner::whereIn('farm_id', $farms->pluck('id'));

        if ($miners->get()->isEmpty()) {
            throw new NotFoundHttpException('no miner found for this user');
        }

        $findMiner = $miners->find($minerId);

        if ($findMiner === null)
            throw new NotFoundHttpException('miner id ' . $minerId . ' not found');

        /** @var Coin $currentMiningCoin */
        $currentMiningCoin = $findMiner->farm->coin;
        $softwareUsage = SoftwareUsage::whereAlgo($currentMiningCoin->coin_algo)->firstOrFail();
        $minerSummaries = $findMiner->minerSummaries()
            ->where('algo', '=', $softwareUsage->algo_setup_name)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->sortBy('created_at');


        if ($minerSummaries->isNotEmpty()) {
            /** @var MinerSummary $lastSeenSummary */
            $lastSeenSummary = $minerSummaries->last();
            $secondPassed = $lastSeenSummary->created_at->diffInSeconds(Carbon::now());

            MinerSummary::disableAuditing();
            if ($secondPassed > 300) {
                $minerSummaries->map(function ($item) {
                    return $item->hashrate = 0;
                });
                for ($i = 0; $i < 20; $i++) {

                    $hardcodedDateForMinerDownPeriod = $this->hardcodedDateForMinerDownPeriod($i, $lastSeenSummary);
                    $minerSummaries->push(MinerSummary::create([
                        'algo' => $lastSeenSummary->algo,
                        'gpu_count' => $lastSeenSummary->gpu_count,
                        'hashrate' => 0,
                        'accepted_hash' => 0,
                        'rejected_hash' => 0,
                        'up_time' => 0,
                        'miner_id' => $lastSeenSummary->miner_id,
                        'created_at' => $hardcodedDateForMinerDownPeriod,
                        'updated_at' => $hardcodedDateForMinerDownPeriod
                    ]));
                }
            } else if ($secondPassed > 15 && $secondPassed <= 300) {
                $shouldRemoveAmount = $secondPassed / 15;
                $minerSummaries = $minerSummaries->slice($shouldRemoveAmount);
                for ($i = 0; $i < $shouldRemoveAmount; $i++) {

                    $hardcodedDateForMinerDownPeriod = $this->hardcodedDateForMinerDownPeriod($i, $lastSeenSummary);
                    $minerSummaries->push(MinerSummary::create([
                        'algo' => $lastSeenSummary->algo,
                        'gpu_count' => $lastSeenSummary->gpu_count,
                        'hashrate' => 0,
                        'accepted_hash' => 0,
                        'rejected_hash' => 0,
                        'up_time' => 0,
                        'miner_id' => $lastSeenSummary->miner_id,
                        'created_at' => $hardcodedDateForMinerDownPeriod,
                        'updated_at' => $hardcodedDateForMinerDownPeriod
                    ]));
                }
            }
        }

        return ResponseHelper::success([
            'summary' => MinerSummaryResource::collection($minerSummaries),
            'current_mining' => new CoinResource($currentMiningCoin)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateMinerSummaryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateMinerSummaryRequest $request)
    {
        //verify api token
        $apiToken = $request->get('api_token');

        /** @var Miner $miner */
        $miner = Miner::whereApiToken($apiToken)->available(true)->first();

        if ($miner === null) {
            throw new NotFoundHttpException('Invalid Api Token');
        }

        MinerSummary::disableAuditing();
        MinerSummary::create([
            'algo' => $request->get('algo'),
            'gpu_count' => $request->get('gpu_count'),
            'hashrate' => $request->get('hashrate'),
            'accepted_hash' => $request->get('accepted_hash'),
            'rejected_hash' => $request->get('rejected_hash'),
            'up_time' => $request->get('up_time'),
            'miner_id' => $miner->id
        ]);

        return ResponseHelper::success([
            'msg' => 'miner summary recorded'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MinerSummary $minerSummary
     * @return \Illuminate\Http\Response
     */
    public function show(MinerSummary $minerSummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\MinerSummary $minerSummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MinerSummary $minerSummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MinerSummary $minerSummary
     * @return \Illuminate\Http\Response
     */
    public function delete(MinerSummary $minerSummary)
    {
        //
    }

    private function hardcodedDateForMinerDownPeriod($index, MinerSummary $lastSeenSummary)
    {
        if ($index > 0) {
            $hardcodedDateForMinerDownPeriod = $lastSeenSummary->created_at->addSecond(($index + 1) * 15);
        } else {
            $hardcodedDateForMinerDownPeriod = $lastSeenSummary->created_at->addSecond(15);
        }

        if ($hardcodedDateForMinerDownPeriod->gt(Carbon::now())) {
            return Carbon::now();
        }

        return $hardcodedDateForMinerDownPeriod;
    }
}
