<?php

namespace App\Botman\Controllers\Conversations;

use App\Models\User;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class BaseConversation extends Conversation
{
    /** @var User */
    protected $user;
    protected $platform;
    protected $platformDbColumnName;

    public function run()
    {
        $this->user = $this->bot->getMessage()->getExtras('user');
        $this->platform = $this->bot->getDriver()->getName();

        if (strtolower($this->platform) === 'telegram') {
            $this->platformDbColumnName = 'tele_id';
        } else if (strtolower($this->platform) === 'facebook') {
            $this->platformDbColumnName = 'fb_id';
        }
    }

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() === '/cancel' || $message->getText() === '/stop') {
            return true;
        }
        return false;
    }

    protected function genBtnFrmModels($models, $colName, $keyName = 'id')
    {
        $arrBtn = [];
        foreach ($models as $model) {
            $arrBtn[] = Button::create($model->$colName)->value($model->$keyName);
        }

        $arrBtn[] = Button::create('Cancel')->value('/cancel');
        return $arrBtn;
    }

    protected function isUserSetTwoFactor()
    {
        return $this->user->secret_2fa !== null;
    }
}