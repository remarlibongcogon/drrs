<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );
    }

    public function sendSms($to, $message)
    {
        $from = env('TWILIO_PHONE_NUMBER'); 
        try {
            return $this->twilio->messages->create(
                $to, // recipient's phone number
                [
                    'from' => $from,
                    'body' => $message
                ]
            );
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
