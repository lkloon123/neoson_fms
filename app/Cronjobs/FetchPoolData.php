<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Cronjobs\Wrapper\PoolWrapper;
use App\Models\Pool;
use App\Models\PoolData;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class FetchPoolData
{
    private $apiList = [];
    private $poolId = [];
    private $poolData = [];

    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function setup()
    {
        $poolList = Pool::available(true)->get();

        foreach ($poolList as $pool) {
            if ($pool->type === 'yiimp') {
                $this->apiList[] = $pool->pool_api . 'currencies';
            } else if ($pool->type === 'oep') {
                $this->apiList[] = $pool->pool_api . 'stats';
            } else if ($pool->type === 'mpos') {
                $this->apiList[] = $pool->pool_api . 'public';
            }
            $this->poolId[] = $pool->id;
        }
    }

    private function fetch()
    {
        //setup pool data to be fetched
        $this->setup();

        //ready to execute api calls
        $promises = $this->buildPromiseRequest();

        //call the api
        $result = Promise\settle($promises)->wait();

        //format the result and return it
        $this->format($result);
    }

    private function buildPromiseRequest()
    {
        $client = new Client(['timeout' => 5]);

        $promises = [];

        for ($i = 0, $apiCount = \count($this->apiList); $i < $apiCount; $i++) {
            $promises = array_add($promises, $this->poolId[$i], $client->getAsync($this->apiList[$i]));
        }

        return $promises;
    }

    private function format($result)
    {
        foreach ($this->poolId as $poolId) {
            if (isset($result[$poolId]['value'])) {
                /** @var ResponseInterface $response */
                $response = $result[$poolId]['value'];
                $this->poolData = array_add($this->poolData, $poolId, json_decode($response->getBody()));
            }
        }

        PoolData::disableAuditing();
        foreach ($this->poolData as $poolId => $poolDetail) {
            try {
                $pool = Pool::find($poolId);
                PoolWrapper::{'load' . title_case($pool->type)}($pool, $poolDetail);
            } catch (Exception $e) {
            }
        }
    }

    public function getPoolData(): array
    {
        return $this->poolData;
    }
}