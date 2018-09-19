<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use App\Mail\NotificationMail;
use App\Models\Notification;
use BotMan\BotMan\Exceptions\Base\BotManException;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Telegram\TelegramDriver;
use Mail;

class NotificationHelper
{
    public static function send(Notification $notification)
    {
        $platformToBeSend = self::buildPlatformBasedOnUserSetting($notification->user->notificationSetting);

        if (\in_array('web', $platformToBeSend)) {
            $notification->save();
        }

        self::sendToEmail($notification, $platformToBeSend);
        self::sendToBot($notification, $platformToBeSend);
    }

    public static function sendToBot(Notification $notification, $platformToBeSend = null)
    {
        if ($platformToBeSend === null) {
            $platformToBeSend = self::buildPlatformBasedOnUserSetting($notification->user->notificationSetting);
        }

        $userBot = $notification->user->bot;

        if ($userBot !== null) {
            $notificationMessage = '*Notification*' . PHP_EOL . $notification->subject;

            if (\in_array('telegram', $platformToBeSend)) {
                if ($userBot->tele_id !== null) {
                    BotHelper::sendToTelegram($notificationMessage, $userBot->tele_id);
                }
            }

            if (\in_array('facebook', $platformToBeSend)) {
                if ($userBot->fb_id !== null) {
                    BotHelper::sendToFacebook($notificationMessage, $userBot->fb_id);
                }
            }
        }
    }

    public static function sendToEmail(Notification $notification, $platformToBeSend = null)
    {
        if ($platformToBeSend === null) {
            $platformToBeSend = self::buildPlatformBasedOnUserSetting($notification->user->notificationSetting);
        }

        if (\in_array('email', $platformToBeSend)) {
            //send email
            Mail::to($notification->user)
                ->send(new NotificationMail($notification));
        }
    }

    private static function buildPlatformBasedOnUserSetting($userNotificationSetting)
    {
        $platformToBeSend = [];

        if ($userNotificationSetting === null) {
            $platformToBeSend[] = 'email';
            $platformToBeSend[] = 'telegram';
            $platformToBeSend[] = 'facebook';
            $platformToBeSend[] = 'web';
        } else {
            if ($userNotificationSetting->email_type_alert) {
                $platformToBeSend[] = 'email';
            }

            if ($userNotificationSetting->telegram_type_alert) {
                $platformToBeSend[] = 'telegram';
            }

            if ($userNotificationSetting->facebook_type_alert) {
                $platformToBeSend[] = 'facebook';
            }

            if ($userNotificationSetting->web_type_alert) {
                $platformToBeSend[] = 'web';
            }
        }

        return $platformToBeSend;
    }
}