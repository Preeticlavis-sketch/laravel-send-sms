<?php

return [

    'default' => env('SMS_PROVIDER', 'twilio'),

    'providers' => [
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        'msg91' => [
            'auth_key' => env('MSG91_AUTH_KEY'),
            'template_id' => env('MSG91_TEMPLATE_ID'),
            'sender_id' => env('MSG91_SENDER_ID'),
        ],
    ],

];
