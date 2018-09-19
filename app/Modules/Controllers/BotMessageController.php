<?php

namespace App\Modules\Controllers;

use App\Helper\BotHelper;
use App\Helper\ResponseHelper;
use App\Models\User;
use App\Modules\Requests\CreateBotMessageRequest;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BotMessageController extends BaseController
{
    public function create(CreateBotMessageRequest $request)
    {
        //check permission
        if (Bouncer::cannot('send_bot_message')) {
            throw new AccessDeniedHttpException('you are not allow to perform this action');
        }

        $allUser = User::where('bot_id', '!=', null)->get();
        $type = $request->get('type');
        $message = '*Announcement*' . PHP_EOL . $request->get('message');
        $targets = $request->get('target');
        $fbMsgCount = 0;
        $teleMsgCount = 0;

        if ($type === 'all') {
            foreach ($allUser as $user) {
                /** @var User $user */
                if ($user->bot->fb_id !== null) {
                    BotHelper::sendToFacebook($message, $user->bot->fb_id);
                    $fbMsgCount++;
                }

                if ($user->bot->tele_id !== null) {
                    BotHelper::sendToTelegram($message, $user->bot->tele_id);
                    $teleMsgCount++;
                }
            }
        } else if ($type === 'fb') {
            if ($targets === null) {
                //send to all fb
                foreach ($allUser as $user) {
                    /** @var User $user */
                    if ($user->bot !== null && $user->bot->fb_id !== null) {
                        BotHelper::sendToFacebook($message, $user->bot->fb_id);
                        $fbMsgCount++;
                    }
                }
            } else {
                //send to target
                foreach ($targets as $target) {
                    $user = User::find($target);
                    if ($user !== null) {
                        if ($user->bot !== null && $user->bot->fb_id !== null) {
                            BotHelper::sendToFacebook($message, $user->bot->fb_id);
                            $fbMsgCount++;
                        }
                    }
                }
            }
        } else if ($type === 'tele') {
            if ($targets === null) {
                //send to all telegram
                foreach ($allUser as $user) {
                    /** @var User $user */
                    if ($user->bot !== null && $user->bot->tele_id !== null) {
                        BotHelper::sendToTelegram($message, $user->bot->tele_id);
                        $teleMsgCount++;
                    }
                }
            } else {
                //send to target
                foreach ($targets as $target) {
                    $user = User::find($target);
                    if ($user !== null) {
                        if ($user->bot !== null && $user->bot->tele_id !== null) {
                            BotHelper::sendToTelegram($message, $user->bot->tele_id);
                            $teleMsgCount++;
                        }
                    }
                }
            }
        }

        return ResponseHelper::success([
            'msg' => 'successfully send message',
            'data' => [
                'fb_msg_count' => $fbMsgCount,
                'tele_msg_count' => $teleMsgCount
            ]
        ]);
    }
}
