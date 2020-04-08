<?php


namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

//use App\Mail\TestMail;
//use Illuminate\Support\Facades\Mail;
use App\utilities\Application;
use App\utilities\PersonalDetails;
use Mail;
use App\Report;

class CybersafetyConversation extends Conversation
{

    public $app;
    public $pd;

    public function welcome()
    {
        $this->app = new Application();
        $this->AskLocale();
        $this->say('Hello, Welcome to Cybersafety website');
        $question = Question::create("Hotline or Helpline?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_what')
            ->addButtons([
                Button::create('Hotline')->value('hotline'),
                Button::create('Helpline')->value('helpline'),

            ]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->app->setCategory($answer->getValue());
//                error_log($this->app->getCategory());
            }
            $this->askWhere();
        });

    }

    public function AskLocale() {
        $question = Question::create("Language?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('English/Αγγλικά')->value('en'),
                Button::create('Greek/Ελληνικα')->value('gr'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
//                $this->where = $answer->getValue();
                App::setLocale($answer->getValue());

                 $this->say("Hello,Για".trans('lang.choose'));
            }
            else {
                App::setLocale("en");
            }
        });
    }

    public function askWhere()
    {
        $question = Question::create("Please select where the incident occured")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Website')->value('website'),
                Button::create('Chat room')->value('chat_room'),
                Button::create('Mobile communication')->value('mobile_communication'),
                Button::create('Social Media')->value('social_media'),
                Button::create('Email')->value('email'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
//                $this->where = $answer->getValue();
                $this->app->setWhere($answer->getValue());
            }
            if ($this->app->getCategory() == 'hotline')
                $this->askTypeHotline();
            else {
                $this->askTypeHelpline();
            }
        });
    }


    public function askTypeHotline()
    {

        $question = Question::create("Please select the type of content of the incident")
            ->fallback('Unable to ask question')
            ->callbackId('ask_type')
            ->addButtons([
                Button::create('Child Pornography')->value('child_pornography'),
                Button::create('Hijacking')->value('hijacking'),
                Button::create('Network Hijacking')->value('network_hijacking'),
                Button::create('Cyber Fraud')->value('cyber_fraud'),
                Button::create('Hate Speech')->value('hate_speech'),
                Button::create('Other')->value('other')
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->type = $answer->getValue();
                $this->app->setType($answer->getValue());
            }
            $this->askDescribe();
        });
    }

    public function askTypeHelpline()
    {

        $question = Question::create("Please select the type of content of the incident")
            ->fallback('Unable to ask question')
            ->callbackId('ask_type')
            ->addButtons([
                Button::create('Cyberbullying')->value('cyberbullying'),
                Button::create('Excessive use')->value('excessive_use'),
                Button::create('Love / Realationships / Sexuality (online)')->value('love_relationships_sexuality'),
                Button::create('Sexting ')->value('sexting'),
                Button::create('Sexual harassment')->value('sexual harassment'),
                Button::create('Grooming ')->value('Grooming'),
                Button::create('E-crime')->value('E-crime'),
                Button::create('Hate speech')->value('hate_speech'),
                Button::create('Potentially harmful content')->value('potentially_harmful_content'),
                Button::create('Gaming')->value('Gaming'),
                Button::create('Online reputation')->value('Online reputation'),
                Button::create('Technical settings')->value('technical_settings'),
                Button::create('Advertising / commercialism')->value('advertising_commercialism'),
                Button::create('Media literacy / education')->value('media_literacy_education'),
                Button::create('Data privacy')->value('data_privacy'),

            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
//                $this->type = $answer->getValue();
                $this->app->setType($answer->getValue());
            }
            $this->askDescribe();
        });


    }

    public function askDescribe()
    {

        $question = Question::create("Please describe the incident")
            ->fallback('Unable to ask question')
            ->callbackId('ask_describe');

        $this->ask($question, function (Answer $answer) {
//            $this->type = $answer->getValue();
            $this->app->setDescription($answer->getValue());
            $this->askPersonalData();
        });

    }

    public function askPersonalData()
    {

        $question = Question::create("Please select one of the two")
            ->fallback('Unable to ask question')
            ->callbackId('ask_personal_data')
            ->addButtons([
                Button::create('I prefer staying anonymous')->value('anonymous'),
                Button::create('I prefer submitting my personal details (strictly confidential)')->value('submit_personal_details'),
            ]);


        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
//                $this->personal_data = $answer->getValue();
                $this->app->setPersonalData($answer->getValue());
            }

            if ($this->app->getPersonalData() == 'anonymous') {

                $this->say('Thank you for contacting us');
                $this->doNotStore();
            } else {
                $this->pd = new PersonalDetails();
                $this->askName();
            }

        });

    }

    public function askName()
    {

        $question = Question::create("Please give us your name")
            ->fallback('Unable to ask question')
            ->callbackId('ask_name');

        $this->ask($question, function (Answer $answer) {
            $this->pd->setName($answer->getValue());
            $this->askSurname();
        });
    }


    public function askSurname()
    {

        $question = Question::create("Please give us your surname")
            ->fallback('Unable to ask question')
            ->callbackId('ask_surname');

        $this->ask($question, function (Answer $answer) {
            $this->pd->setSurname($answer->getValue());
            $this->askEmail();
        });
    }

    public function askEmail()
    {

        $question = Question::create("Please give us your email")
            ->fallback('Unable to ask question')
            ->callbackId('ask_email');

        $this->ask($question, function (Answer $answer) {
            $this->pd->setEmail($answer->getValue());
            $this->askPhone();
        });
    }

    public function askPhone()
    {

        $question = Question::create("Please give us your phone")
            ->fallback('Unable to ask question')
            ->callbackId('ask_phone');

        $this->ask($question, function (Answer $answer) {
            $this->pd->setPhone($answer->getValue());
            $this->askAge();
        });
    }

    public function askAge()
    {

        $question = Question::create("Please give us your age")
            ->fallback('Unable to ask question')
            ->callbackId('ask_age')
            ->addButtons([
                Button::create('5-11 years')->value('five_to_eleven'),
                Button::create('12-18 years')->value('twelve_to_eighteen'),
                Button::create('18+ years')->value('eighteen_plus'),

            ]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->pd->setAge($answer->getValue());

            }
            $this->askGender();
        });

    }

    public function askGender()
    {

        $question = Question::create("Please give us your gender")
            ->fallback('Unable to ask question')
            ->callbackId('ask_gender')
            ->addButtons([
                Button::create('Male')->value('male'),
                Button::create('Female')->value('female'),

            ]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->pd->setGender($answer->getValue());

            }

            $this->app->setPersonalDetails($this->pd);
            $this->say('Thank you for contacting us');

            $this->doStore();

        });

    }


    public function doStore()
    {

        //store personal data in database and send the email to the operator

        //check if personal data is captured correctly
        error_log($this->pd->getName());
        error_log($this->pd->getSurname());
        error_log($this->pd->getEmail());
        error_log($this->pd->getPhone());
        error_log($this->pd->getAge());
        error_log($this->pd->getGender());

        $this->storeToDB();

        $this->sendEmail();


    }

    public function doNotStore()
    {
        //Do not store personal data (only application data) in database  and send the email to the operator
        //Check if application data is captured correctly


        error_log($this->app->getCategory());
        error_log($this->app->getWhere());
        error_log($this->app->getType());
        error_log($this->app->getDescription());
        error_log($this->app->getPersonalData()); //this is anonymous or non-anonymous

        $this->storeToDB();
        $this->sendEmail();

    }

    //cybersafe.chatbot@gmail.com
    //chat123!
    public function sendEmail()
    {
        $to_name = 'CyberSafe Team';
        $to_email = 'iacovos.ioannou@gmail.com';
        $data = array("name" => "CyberSafe Chatbot Reciever of CyberSafe Team", 'results' => $this->app->returnResultOfChatBot(), 'personal_information' => $this->pd->getPersonalDetails(), "body" => "With Regards CyberSafe ChatBot");
        Mail::send('emails.emailnotify', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('CyberSafe Chatbot Result for Report');
            $message->from('cybersafe.chatbot@gmail.com', 'CyberSafe Chatbot Mail');
        });

    }


    public function storeToDB()
    {
        $data = Array();
        $data['category'] = $this->app->getCategory();
        $data['where'] = $this->app->getWhere();
        $data['type'] = $this->app->getType();
        $data['description'] = $this->app->getDescription();
        $data['personal_data'] = $this->app->getPersonalData();
        $data['personal_details'] = $this->app->getPersonalDetails();
        $data['name'] = $this->pd->getName();
        $data['surname'] = $this->pd->getSurname();
        $data['email'] = $this->pd->getEmail();
        $data['phone'] = $this->pd->getPhone();
        $data['age'] = $this->pd->getAge();
        $data['gender'] = $this->pd->getGender();
        $id = Report::create($data)->id;

    }


    public function run()
    {
        $this->welcome();

    }


}
