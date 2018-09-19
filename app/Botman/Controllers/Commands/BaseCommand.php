<?php

namespace App\Botman\Controllers\Commands;

use App\Api\V1\Controllers\BaseController;
use App\Botman\Controllers\Conversations\FMSLinkConversation;
use App\Models\User;
use BotMan\BotMan\BotMan;

class BaseCommand extends BaseController
{
    /** @var User */
    protected $user;
    protected $platform;
    protected $platformDbColumnName;

    public function handle()
    {
        $botman = app('botman');

        $middleware = new \App\Botman\Middleware\LoadBotUser();
        $botman->middleware->received($middleware);

        $botman->listen();
    }

    protected function setup(Botman $bot)
    {
        $bot->types();

        $this->user = $bot->getMessage()->getExtras('user');
        $this->platform = $bot->getDriver()->getName();

        if (strtolower($this->platform) === 'telegram') {
            $this->platformDbColumnName = 'tele_id';
        } else if (strtolower($this->platform) === 'facebook') {
            $this->platformDbColumnName = 'fb_id';
        }
    }

    protected function sendFMSLinkMsg(BotMan $bot)
    {
        $bot->reply('Seems like you haven link with your FMS account');
        $bot->reply('I will guide you to link with your FMS account');
        $bot->startConversation(new FMSLinkConversation());
    }
}
