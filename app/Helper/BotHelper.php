<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use BotMan\BotMan\Exceptions\Base\BotManException;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Telegram\TelegramDriver;

class BotHelper
{
    public static function sendToTelegram($message, $tele_id)
    {
        $botman = app('botman');
        try {
            $botman->say($message, $tele_id, TelegramDriver::class);
        } catch (BotManException $e) {
        }
    }

    public static function sendToFacebook($message, $fb_id)
    {
        $botman = app('botman');
        try {
            $botman->say($message, $fb_id, FacebookDriver::class);
        } catch (BotManException $e) {
        }
    }
}