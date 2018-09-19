<?php

namespace App\Botman\Controllers\Commands;

use App\Botman\Controllers\Conversations\BalanceConversation;
use BotMan\BotMan\BotMan;

class BalanceCommand extends BaseCommand
{
    public function handleBalanceCommand(BotMan $bot)
    {
        $this->setup($bot);

        if ($this->user === null) {
            $this->sendFMSLinkMsg($bot);
        } else {
            $bot->startConversation(new BalanceConversation());
        }
    }
}
