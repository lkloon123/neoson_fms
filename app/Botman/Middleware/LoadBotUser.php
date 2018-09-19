<?php

namespace App\Botman\Middleware;

use App\Models\Bot;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class LoadBotUser implements Received
{
    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $platform = $bot->getDriver()->getName();
        $botKey = $message->getSender();

        $botColumnName = '';
        $user = null;

        if (strtolower($platform) === 'telegram') {
            $botColumnName = 'tele_id';
        } else if (strtolower($platform) === 'facebook') {
            $botColumnName = 'fb_id';
        }

        if ($botColumnName !== '') {
            $bot = Bot::where($botColumnName, $botKey)->first();

            if ($bot !== null) {
                $user = $bot->user;
            }
        }

        $message->addExtras('user', $user);
        return $next($message);
    }
}
