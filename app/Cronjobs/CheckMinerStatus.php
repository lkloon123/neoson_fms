<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;

use App\Helper\NotificationHelper;
use App\Models\Farm;
use App\Models\Miner;
use App\Models\MinerSummary;
use App\Models\Notification;
use Carbon\Carbon;

class CheckMinerStatus
{
    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function fetch()
    {
        $farmList = Farm::all();

        /** @var Farm $farm */
        /** @var Miner $miner */
        foreach ($farmList as $farm) {
            foreach ($farm->miners as $miner) {
                if ($farm->coin !== null && $miner->is_notification_enabled === 1) {
                    $this->validateMiner($miner);
                }
            }
        }
    }

    private function validateMiner(Miner $miner)
    {
        $minerSummaries = MinerSummary::whereMinerId($miner->id)->latest()->limit(40)->get();
        if ($minerSummaries->isEmpty()) {
            $this->sendNotification($miner);
            return;
        }

        $zeroHashrate = $minerSummaries->where('hashrate', '=', 0);
        if ($zeroHashrate->isNotEmpty()) {
            if ($zeroHashrate->count() === 40) {
                $this->sendNotification($miner);
                return;
            }
        }

        if ($minerSummaries->first()->created_at->addMinutes(10) < Carbon::now()) {
            $this->sendNotification($miner);
            return;
        }
    }

    private function sendNotification(Miner $miner)
    {
        if ($miner->notification_sent_timestamp === null || $miner->notification_sent_timestamp->addMinutes(60) < Carbon::now()) {
            $farm = $miner->farm;
            $users = $farm->users;

            foreach ($users as $user) {
                $notificationTmp = new Notification([
                    'subject' => 'Miner [' . $miner->miner_name . '] in farm [' . $farm->farm_name . '] down',
                    'type' => 'alert',
                    'user_id' => $user->id
                ]);

                NotificationHelper::sendToBot($notificationTmp);
            }

            $miner->timestamps = false;
            $miner->update([
                'notification_sent_timestamp' => Carbon::now()
            ]);
        }
    }
}