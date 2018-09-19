<?php

use BotMan\BotMan\BotMan;

$botman = resolve('botman');

$botman->hears('/help', function (BotMan $bot) {
    $bot->types();
    $bot->reply(
        'Available Commands
        
/start - Start The Bot
/link - Link NeoSon Crypto With Your Bot
/balance - Get Your Farm Balance
/startminer - Remote Start Your Farm
/help - Get A List Of Available Commands
/stop - Stop Current Operation
/cancel - Cancel Current Operation'
    );
});

$botman->fallback(function (Botman $bot) {
    $bot->types();
    $bot->reply('Sorry, command not found. You can user /help');
});

$botman->hears('/cancel', 'App\Botman\Controllers\Commands\CancelCommand@handleCancelCommand')->stopsConversation();
$botman->hears('/stop', 'App\Botman\Controllers\Commands\CancelCommand@handleCancelCommand')->stopsConversation();

$botman->hears('/balance', 'App\Botman\Controllers\Commands\BalanceCommand@handleBalanceCommand');
$botman->hears('/link', 'App\Botman\Controllers\Commands\FMSLinkCommand@handleFMSLinkCommand');
$botman->hears('/startminer', 'App\Botman\Controllers\Commands\StartMinerCommand@handleStartMinerCommand');
$botman->hears('/start {email}', 'App\Botman\Controllers\Commands\StartCommand@handleStartCommand');
$botman->hears('/start', 'App\Botman\Controllers\Commands\StartCommand@handleStartCommand');