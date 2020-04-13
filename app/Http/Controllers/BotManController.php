<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use App\Conversations\ExampleConversationIacovos;
use App\Conversations\CybersafetyConversation;
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('welcome');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }


    public function startCybersafetyConversation(BotMan $bot)
    {
        $bot->startConversation(new CyberSafetyConversation());
    }



    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversationIacovos(BotMan $bot)
    {
               $bot->startConversation(new ExampleConversationIacovos());
    }


    public function getCurrency($currency)
    {
        $client = new Client();
        $uri = 'http://api.fixer.io/latest?base='.$currency;
        $response = $client->get($uri);
        $results = json_decode($response->getBody()->getContents());

        $date = date('d F Y', strtotime($results->date));
        $data = "Here's the exchange rates based on ".$currency." currency\nDate: ".$date."\n";
        foreach($results->rates as $k => $v) {
            $data .= $k." - ".$v."\n";
        }

        return $data;
    }

}
