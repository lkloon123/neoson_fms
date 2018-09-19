<?php

namespace App\Botman\Controllers\Commands;

use App\Botman\Controllers\Conversations\StartMinerConversation;
use BotMan\BotMan\BotMan;

class StartMinerCommand extends BaseCommand
{
    public function handleStartMinerCommand(BotMan $bot)
    {
        $this->setup($bot);

        if ($this->user === null) {
            $this->sendFMSLinkMsg($bot);
        } else {
            $bot->startConversation(new StartMinerConversation());
        }
    }
}
