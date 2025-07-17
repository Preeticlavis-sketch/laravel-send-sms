<?php

namespace Preeti\SmsSender;

use Preeti\SmsSender\Drivers\Msg91Driver;
use Preeti\SmsSender\Drivers\TwilioDriver;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class SmsManager
{
    protected $driver;

    public function __construct()
    {
        $driver = Config::get('sms.default');

        switch ($driver) {
            case 'msg91':
                $this->driver = new Msg91Driver();
                break;

            case 'twilio':
                $this->driver = new TwilioDriver();
                break;

            default:
                throw new InvalidArgumentException("Unsupported SMS driver: $driver");
        }
    }

    public function sendTemplate(string $templateKey, string $to, array $data = [])
    {
        $template = Config::get("sms.templates.$templateKey");

        if (!$template || !isset($template['body']) || !isset($template['template_id'])) {
            throw new InvalidArgumentException("Template [$templateKey] not found or is invalid in sms config.");
        }

        $message = $template['body'];

        foreach ($data as $key => $value) {
            $message = str_replace("{{{$key}}}", $value, $message);
        }

        return $this->driver->send($to, $message, $template['template_id']);
    }
}
