<?php

namespace Preeti\SmsSender\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91Driver
{
    public function send($to, $message, $templateId)
    {
        $authKey   = config('sms.providers.msg91.auth_key');
        $senderId  = config('sms.providers.msg91.sender_id');
        $headerId  = config('sms.header_id');

        $payload = [
            'template_id' => $templateId,
            'short_url'   => false,
            'sender'      => $senderId,
            'DLT_TE_ID'   => $templateId, // Optional, depending on MSG91’s DLT rules
            'route'       => '4', // transactional route
            'country'     => '91',
            'sms' => [
                [
                    'message' => $message,
                    'to' => [$to]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'authkey' => $authKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.msg91.com/api/v5/message', $payload);

        // Optional: log or handle failure
        if (!$response->successful()) {
            Log::error('MSG91 SMS failed', [
                'response' => $response->body(),
                'payload' => $payload
            ]);
        }

        return $response->json();
    }
}
