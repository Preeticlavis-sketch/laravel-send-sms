<?php

namespace Preeti\SmsSender\Drivers;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class TwilioDriver
{
    protected $twilio;

    public function __construct()
    {
        $sid    = Config::get('sms.providers.twilio.sid');
        $token  = Config::get('sms.providers.twilio.token');

        $this->twilio = new Client($sid, $token);
    }

    /**
     * Send SMS using Twilio
     *
     * @param string $to Recipient phone number (E.164 format, e.g. +919999999999)
     * @param string $message Message body
     * @param string|null $templateId Optional (Twilio does not use templateId directly)
     * @return array Twilio response array
     */
    public function send($to, $message, $templateId = null)
    {
        try {
            $from = Config::get('sms.providers.twilio.from');

            $response = $this->twilio->messages->create($to, [
                'from' => $from,
                'body' => $message,
            ]);

            return [
                'sid' => $response->sid,
                'status' => $response->status,
                'to' => $response->to,
                'from' => $response->from,
                'body' => $response->body,
            ];
        } catch (\Exception $e) {
            Log::error('Twilio SMS failed', [
                'error' => $e->getMessage(),
                'to' => $to,
                'message' => $message,
            ]);

            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
