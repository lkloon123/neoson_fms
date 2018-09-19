<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Cronjobs\Wrapper\MarketWrapper;
use App\Models\Market;
use App\Models\MarketData;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class FetchMarketData
{
    private $apiList = [];
    private $marketId = [];
    private $marketData = [];

    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function setup()
    {
        $marketList = Market::available(true)->get();

        foreach ($marketList as $market) {
            $this->apiList[] = $market->market_api;
            $this->marketId[] = $market->id;
        }
    }

    private function fetch()
    {
        //setup market data to be fetched
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
            $promises = array_add($promises, $this->marketId[$i], $client->getAsync($this->apiList[$i]));
        }

        return $promises;
    }

    private function format($result)
    {
        foreach ($this->marketId as $marketId) {
            if (isset($result[$marketId]['value'])) {
                /** @var ResponseInterface $response */
                $response = $result[$marketId]['value'];
                $this->marketData = array_add($this->marketData, $marketId, json_decode($response->getBody()));
            }
        }

        MarketData::disableAuditing();
        foreach ($this->marketData as $marketId => $marketDetail) {
            try {
                $market = Market::find($marketId);
                MarketWrapper::{'load' . title_case($market->market_name)}($marketId, $marketDetail);
            } catch (Exception $e) {
            }
        }
    }

    public function getMarketData(): array
    {
        return $this->marketData;
    }
}