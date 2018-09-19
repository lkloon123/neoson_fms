<?php

namespace App\Botman\Controllers\Commands;

use App\Botman\Controllers\Conversations\FMSLinkConversation;
use App\Helper\EmojiHelper;
use BotMan\BotMan\BotMan;

class FMSLinkCommand extends BaseCommand
{
    public function handleFMSLinkCommand(BotMan $bot)
    {
        $this->setup($bot);

        if ($this->user === null) {
            $bot->startConversation(new FMSLinkConversation());
        } else {
            $bot->reply(EmojiHelper::SUCCESS . ' This ' . $this->platform . ' account has link with ' . $this->user->email);
        }
    }
}
