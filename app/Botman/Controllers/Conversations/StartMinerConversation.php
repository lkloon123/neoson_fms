<?php

namespace App\Botman\Controllers\Conversations;

use App\Helper\EmojiHelper;
use App\Helper\HashrateHelper;
use App\Helper\TwoFactorHelper;
use App\Models\Coin;
use App\Models\Pool;
use App\Models\WalletControl;
use App\Modules\Controllers\RemoteStartController;
use App\Modules\Requests\StartMiningRequest;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StartMinerConversation extends BaseConversation
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
                    $this->askForPool();
                } else {
                    $this->say(EmojiHelper::WARNING . ' Please Select using buttons ' . EmojiHelper::WARNING);
                    $this->askForTicker();
                }
            });
        }
    }

    public function askForPool()
    {
        $selectedCoin = Coin::whereId($this->bot->userStorage()->get('coin_id'))->first();

        try {
            $poolDatas = (new RemoteStartController())->poolData($selectedCoin->coin_ticker);
            $formattedPoolData = collect();

            foreach ($poolDatas as $poolData) {
                $temp = new Pool();
                $temp->id = $poolData->id;
                $temp->pool_name = $poolData->pool_name . ' (' . HashrateHelper::convert($poolData->hashrate) . ')';
                $formattedPoolData->push($temp);
            }

            $question = Question::create(EmojiHelper::POINT_DOWN . ' Please select a Pool ' . EmojiHelper::POINT_DOWN)
                ->fallback('Unable to ask question')
                ->callbackId('ask_pool')
                ->addButtons($this->genBtnFrmModels($formattedPoolData, 'pool_name'));

            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->bot->userStorage()->save(['pool_id' => $answer->getValue()]);
                    $this->askForTwoFactor();
                } else {
                    $this->say(EmojiHelper::WARNING . ' Please Select using buttons ' . EmojiHelper::WARNING);
                    $this->askForPool();
                }
            });
        } catch (NotFoundHttpException $e) {
            $this->say(EmojiHelper::CRY . " There's No Pool Available For This Coin");
        }
    }

    public function askForTwoFactor()
    {
        $this->ask(EmojiHelper::EDIT . ' Please enter your Two Factor Code', function (Answer $answer) {
            $this->bot->userStorage()->save(['twofa_code' => $answer->getText()]);
            $this->say(EmojiHelper::LOADING . ' Please Wait...');
            $this->sendCommand();
        });
    }

    public function sendCommand()
    {
        try {
            //make the test
            TwoFactorHelper::verifyCode($this->user, $this->bot->userStorage()->get('twofa_code'));

            $formRequest = new StartMiningRequest();
            $formRequest->request->add([
                'farm_id' => $this->bot->userStorage()->get('farm_id'),
                'coin_ticker' => Coin::find($this->bot->userStorage()->get('coin_id'))->coin_ticker,
                'pool_id' => $this->bot->userStorage()->get('pool_id'),
                'twofa_code' => $this->bot->userStorage()->get('twofa_code')
            ]);

            try {
                (new RemoteStartController())->start($formRequest);
                $this->say(EmojiHelper::SUCCESS . ' Miner Successfully Started');
            } catch (NotFoundHttpException $e) {
                $this->say(EmojiHelper::ERROR . ' ' . $e->getMessage());
            } catch (HttpException $e) {
                $this->say(EmojiHelper::ERROR . ' ' . $e->getMessage());
            } finally {
                $this->bot->userStorage()->delete();
            }

        } catch (AccessDeniedHttpException $e) {
            //failed
            $this->say(EmojiHelper::ERROR . ' ' . $e->getMessage());
            $this->askForTwoFactor();
        }
    }

    public function run()
    {
        parent::run();
        if ($this->isUserSetTwoFactor()) {
            $this->askForFarm();
        } else {
            $this->say(EmojiHelper::ERROR . ' Please Setup Two Factor First');
        }
    }
}
