<?php

use App\Conversations\CybersafetyConversation;
use App\Conversations\ExampleConversationIacovos;
use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use App\Conversations;

//$help = soundex('help');
//$form = soundex('form');
//$incoming = '';
$botman = resolve('botman');

//$incoming = ($botman->getMessage()->getText());
//error_log($incoming);

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

// Give the bot something to listen for.
$botman->hears('hello', function ($bot) {
    $bot->reply('Hello yourself.');
});

// Give the bot something to listen for.
$botman->hears('hello to you', function ($bot) {
    $bot->reply('You like hellos ... ');
});

// Simple respond method
$botman->hears('Hello', function ($bot) {
    $bot->reply('Hi there :)');
});

$botman->hears('Give me {currency} rates', function ($bot, $currency) {
    $bot->types();
    $results = $this->getCurrency($currency);
    $bot->reply($results);
});

$botman->fallback(function ($bot) {
    $bot->types();
    $bot->reply('Sorry, I did not understand these commands. Please retype again...');
});

$botman->hears('call me {name}', function ($bot, $name) {
    $bot->reply('Your name is: ' . $name);
});


$botman->hears(('Start conversation'), BotManController::class . '@startConversation');

//$botman->hears('help', BotManController::class . '@startConversationIacovos');
//$botman->hears('form', BotManController::class . '@startCybersafetyConversation');

$botman->hears('.*', function ($bot) {
    $incoming = ($bot->getMessage()->getText());

    if (soundex($incoming) == soundex('form'))
        $bot->startConversation(new CyberSafetyConversation());
    elseif (soundex($incoming) == soundex('help'))
        $bot->startConversation(new ExampleConversationIacovos());

    else  $bot->reply('Sorry, I did not understand these commands. Please retype again...');

});


