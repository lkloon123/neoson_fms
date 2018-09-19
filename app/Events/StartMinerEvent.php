<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartMinerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $minerApiToken;
    public $software;
    public $exe_name;
    public $config;

    public function __construct($minerApiToken, $software, $exe_name, $config)
    {
        $this->minerApiToken = $minerApiToken;
        $this->software = $software;
        $this->exe_name = $exe_name;
        $this->config = $config;
    }

    public function broadcastAs()
    {
        return 'StartMiner';
    }

    public function broadcastOn()
    {
        return new Channel('miner.' . $this->minerApiToken);
    }
}
