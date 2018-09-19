<?php

namespace App\Botman\Controllers\Commands;

use App\Helper\EmojiHelper;
use BotMan\BotMan\BotMan;

class CancelCommand extends BaseCommand
{
    public function handleCancelCommand(BotMan $bot)
    {
        $this->setup($bot);

        $bot->userStorage()->delete();

        if ($this->platform) {
            $bot->reply('Operation Canceled. ' . EmojiHelper::SUCCESS, ['reply_markup' => json_encode(['remove_keyboard' => true])]);
        } else {
            $bot->reply('Operation Canceled. ' . EmojiHelper::SUCCESS);
        }
    }
}
