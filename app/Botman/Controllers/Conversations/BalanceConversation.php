<?php

namespace App\Botman\Controllers\Conversations;

use App\Helper\BitcoinHelper;
use App\Helper\EmojiHelper;
use App\Models\Coin;
use App\Models\Miner;
use App\Models\WalletControl;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use Denpa\Bitcoin\Exceptions\BitcoindException;
use Denpa\Bitcoin\Exceptions\ClientException;

class BalanceConversation extends BaseConversation
{
    public function askForFarm()
    {
        $farms = $this->user->farms;

        if ($farms->isEmpty()) {
            $this->say(EmojiHelper::CRY . ' You Dont Have Any Farm');
        } else {
            $question = Question::create(EmojiHelper::POINT_DOWN . ' Please select your Farm ' . EmojiHelper::POINT_DOWN)
                ->fallback('Unable to ask question')
                ->callbackId('ask_farm')
                ->addButtons($this->genBtnFrmModels($farms, 'farm_name'));

            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->bot->userStorage()->save(['farm_id' => $answer->getValue()]);
                    $this->askForTicker();
                } else {
                    $this->say(EmojiHelper::WARNING . ' Please Select using buttons ' . EmojiHelper::WARNING);
                    $this->askForFarm();
                }
            });
        }
    }

    public function askForTicker()
    {
        $coins = Coin::whereIn('id', WalletControl::all(['coin_id']))->get();

        if ($coins->isEmpty()) {
            $this->say(EmojiHelper::CRY . " There's No Coin Available Now");
        } else {
            $question = Question::create(EmojiHelper::POINT_DOWN . ' Please select a Ticker ' . EmojiHelper::POINT_DOWN)
                ->fallback('Unable to ask question')
                ->callbackId('ask_ticker')
                ->addButtons($this->genBtnFrmModels($coins, 'coin_ticker'));

            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->bot->userStorage()->save(['coin_id' => $answer->getValue()]);
                    $this->showResult();
                } else {
                    $this->say(EmojiHelper::WARNING . ' Please Select using buttons ' . EmojiHelper::WARNING);
                    $this->askForTicker();
                }
            });
        }
    }

    public function showResult()
    {
        $selectedFarm = $this->user->farms()->find($this->bot->userStorage()->get('farm_id'));
        $selectedCoin = Coin::find($this->bot->userStorage()->get('coin_id'));
        $this->say("Selected Farm : {$selectedFarm->farm_name}");
        $this->say("Selected Coin : {$selectedCoin->coin_ticker}");

        try {

            //get address based on farm
            $farmTotal = 0;
            $bitcoinHelper = new BitcoinHelper($selectedCoin);

            $miners = $selectedFarm->miners()->get();
            foreach ($miners as $miner) {
                /** @var Miner $miner */
                $wallets = $miner->wallets()->whereCoinId($selectedCoin->id)->get();

                $minerBalance = 0;
                foreach ($wallets as $wallet) {
                    $walletBalance = $bitcoinHelper->getBalanceByWallet($wallet);
                    if ($walletBalance === false) {
                        $walletBalance = 0;
                    }
                    $minerBalance += $walletBalance;
                }
                $farmTotal += $minerBalance;

                if ($wallets->count() > 0) {
                    $this->say($miner->miner_name . " balance : {$minerBalance} {$selectedCoin->coin_ticker}");
                }
            }

            $this->say("Total balance : {$farmTotal} {$selectedCoin->coin_ticker}");
        } catch (ClientException $e) {
            $this->say(EmojiHelper::ERROR . 'Wallet Offline, Please Try Again Later');
        } catch (BitcoindException $e) {
            $this->say(EmojiHelper::ERROR . 'Wallet Offline, Please Try Again Later');
        } finally {
            $this->bot->userStorage()->delete();
        }
    }

    public function run()
    {
        parent::run();
        $this->askForFarm();
    }
}
