<?php

namespace App\Botman\Controllers\Conversations;

use App\Helper\EmojiHelper;
use App\Models\Bot;
use App\Models\User;
use Auth;
use BotMan\BotMan\Messages\Incoming\Answer;

class FMSLinkConversation extends BaseConversation
{
    public function preFMSSyncSetup()
    {
        $this->ask(EmojiHelper::EDIT . ' Please enter your FMS Email', function (Answer $answer) {
            if (!$this->validateEmail($answer->getText())) {
                $this->preFMSSyncSetup();
            } else {
                $this->askForPassword();
            }
        });
    }

    private function askForPassword()
    {
        $this->ask(EmojiHelper::EDIT . 'Please Enter Password', function (Answer $answer) {
            if (!$this->validatePasswordAndSave($answer->getText())) {
                $this->askForPassword();
            }
        });
    }

    private function validateEmail($email)
    {
        $findUser = User::whereEmail($email)->first();

        if ($findUser === null) {
            $this->say(EmojiHelper::ERROR . ' No user found with this email');
            return false;
        }

        $this->bot->userStorage()->save(['registerEmail' => $email]);

        return true;
    }

    private function validatePasswordAndSave($password)
    {
        //validate password
        if (!Auth::attempt([
            'email' => $this->bot->userStorage()->get('registerEmail'),
            'password' => $password,
        ])) {
            $this->say(EmojiHelper::ERROR . ' Incorrect Password');
            return false;
        }

        $findUser = User::whereEmail($this->bot->userStorage()->get('registerEmail'))->first();

        if ($findUser === null) {
            $this->say(EmojiHelper::ERROR . ' No user found with this email');
            return false;
        }

        $checkBot = $findUser->bot;

        if ($checkBot === null) {
            //create a new bot and register to it
            $checkBot = Bot::create([
                'available' => true
            ]);

            $findUser->update([
                'bot_id' => $checkBot->id
            ]);
        }

        //check if platform synced
        if ($checkBot->{$this->platformDbColumnName} !== null) {
            $this->say(EmojiHelper::ERROR . ' This email already link with bot id ' . $checkBot->{$this->platformDbColumnName});
            return false;
        }

        $checkBot->update([
            $this->platformDbColumnName => $this->getBot()->getMessage()->getSender(),
        ]);

        $this->say(EmojiHelper::SUCCESS . ' Done! This ' . $this->platform . ' account is link with ' . $findUser->email);
        return true;
    }

    public function run()
    {
        parent::run();
        $this->preFMSSyncSetup();
    }
}
