<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class ExampleConversationIacovos extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {

        $question = Question::create("Language/Γλώσσα?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Ελ')->value('gr'),
                Button::create('En')->value('en'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'gr') {
                    //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say("Ellinika");//;$joke->value->joke);

                    $question = Question::create("Hello. What Do you want?")
                        ->fallback('Unable to ask question')
                        ->callbackId('ask_reason')
                        ->addButtons([
                            Button::create('HotLine')->value('hotline'),
                            Button::create('HelpLine')->value('helpline'),
                        ]);

                    return $this->ask($question, function (Answer $answer) {
                        if ($answer->isInteractiveMessageReply()) {
                            if ($answer->getValue() === 'hotline') {
                                //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                                $replyis=" I LOVE HOTLINE";
                                $this->say($replyis);//;$joke->value->joke);
                            } else {
                                $this->say("i love helpline");//Inspiring::quote()
                            }
                        }
                    });

                } else {
                    $this->say("Agglika");//Inspiring::quote()
                    $question = Question::create("Hello. What Do you want?")
                        ->fallback('Unable to ask question')
                        ->callbackId('ask_reason')
                        ->addButtons([
                            Button::create('HotLine')->value('hotline'),
                            Button::create('HelpLine')->value('helpline'),
                        ]);

                    return $this->ask($question, function (Answer $answer) {
                        if ($answer->isInteractiveMessageReply()) {
                            if ($answer->getValue() === 'hotline') {
                                //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                                $replyis=" I LOVE HOTLINE";
                                $this->say($replyis);//;$joke->value->joke);
                            } else {
                                $this->say("i love helpline");//Inspiring::quote()
                            }
                        }
                    });
                }
            }
        });

    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
