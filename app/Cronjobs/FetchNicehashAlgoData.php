<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Models\NicehashAlgo;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FetchNicehashAlgoData
{
    private $api = 'https://api.nicehash.com/api?method=multialgo.info';

    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function fetch()
    {
        $client = new Client(['timeout' => 5]);

        //call the api
        $promise = $client->getAsync($this->api);

        $promise->then(
            function (ResponseInterface $response) {
                //format the result and return it
                $this->format($response);
            },
            function (RequestException $error) {
                throw new HttpException(500, $error->getMessage());
            }
        );

        $promise->wait();
    }

    private function format(ResponseInterface $response)
    {
        $result = json_decode((string)$response->getBody());

        if ($result->result->multialgo) {
            //remove all data if result is available
            NicehashAlgo::truncate();
        }

        foreach ($result->result->multialgo as $algo) {
            NicehashAlgo::create([
                'name' => strtolower($algo->name),
                'algo_id' => $algo->algo,
                'port' => $algo->port,
            ]);
        }
    }
}