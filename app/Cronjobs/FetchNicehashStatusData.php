<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Helper\NotificationHelper;
use App\Models\NicehashAccount;
use App\Models\Notification;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class FetchNicehashStatusData
{
    private $apiList = [];
    private $nicehashAccountId = [];
    private $nicehashAccountData = [];

    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function setup()
    {
        $nicehashAccountList = NicehashAccount::all();

        foreach ($nicehashAccountList as $nicehashAccount) {
            if ($nicehashAccount->is_notification_enabled === 1) {
                $this->apiList[] = 'https://api.nicehash.com/api?method=stats.provider.workers&addr=' . $nicehashAccount->wallet_address;
                $this->nicehashAccountId[] = $nicehashAccount->id;
            }
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
            $promises = array_add($promises, $this->nicehashAccountId[$i], $client->getAsync($this->apiList[$i]));
        }

        return $promises;
    }

    private function format($result)
    {
        foreach ($this->nicehashAccountId as $nicehashAccountId) {
            if (isset($result[$nicehashAccountId]['value'])) {
                /** @var ResponseInterface $response */
                $response = $result[$nicehashAccountId]['value'];
                $this->nicehashAccountData = array_add($this->nicehashAccountData, $nicehashAccountId, json_decode($response->getBody()));
            }
        }

        foreach ($this->nicehashAccountData as $nicehashAccountId => $nicehashStatus) {
            $nicehashAccount = NicehashAccount::find($nicehashAccountId);

            if (empty($nicehashStatus->result->workers)) {
                if ($nicehashAccount->should_send_notification === 1) {
                    $notificationTmp = new Notification([
                        'subject' => 'Nicehash account [' . $nicehashAccount->account_name . '] down',
                        'type' => 'alert',
                        'user_id' => $nicehashAccount->user_id
                    ]);

                    NotificationHelper::sendToBot($notificationTmp);
                    if ($nicehashAccount->is_notify_once === 1) {
                        $nicehashAccount->update([
                            'should_send_notification' => false
                        ]);
                    }
                }

            } else {
                $nicehashAccount->update([
                    'should_send_notification' => true
                ]);
            }
        }
    }
}