<?php

namespace App\Botman\Controllers\Commands;

use App\Helper\EmojiHelper;
use BotMan\BotMan\BotMan;

class StartCommand extends BaseCommand
{
    public function handleStartCommand(BotMan $bot)
    {
        $this->setup($bot);

        $bot->reply(EmojiHelper::MONEY_BAG . ' Welcome to NeoSon Crypto Farm Management System! ' . EmojiHelper::MONEY_BAG);
        $bot->reply(EmojiHelper::SUCCESS . ' Your ' . $bot->getDriver()->getName() . ' ID : ' . $bot->getUser()->getId());

        $this->checkFmsLinkStatus($bot);
    }

    private function checkFmsLinkStatus(BotMan $bot)
    {
        if ($this->user === null) {
            $this->sendFMSLinkMsg($bot);
        } else {
            $bot->reply(EmojiHelper::SUCCESS . ' Your FMS User Email : ' . $this->user->email);
        }
    }
}
