<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

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

$botman->fallback(function($bot) {
    $bot->types();
    $bot->reply('Sorry, I did not understand these commands. Please retype again...');
});

$botman->hears('call me {name}', function ($bot, $name) {
    $bot->reply('Your name is: '.$name);
});


$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('help', BotManController::class.'@startConversationIacovos');
$botman->hears('form', BotManController::class.'@startCybersafetyConversation');
