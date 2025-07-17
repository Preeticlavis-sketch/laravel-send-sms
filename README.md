# Laravel SMS Sender 📲

Send DLT-compliant SMS messages in Laravel using **MSG91** or **Twilio** with a plug-and-play package.

> 🔐 Built with support for DLT header IDs, dynamic templates, and clean Laravel integration.

---

## ✨ Features

- ✅ Supports **MSG91** and **Twilio**
- ✅ Send OTPs and messages via **pre-approved templates**
- ✅ Easy to plug into any Laravel project
- ✅ Use config-based templates with variables like `{{otp}}`
- ✅ Swappable drivers (MSG91, Twilio)
- ✅ Publish config for full control

---

## 📦 Installation

```bash
composer require preeti/laravel-sms-sender
php artisan vendor:publish --tag=config



SMS_DRIVER=msg91        # or twilio

SMS_HEADER_ID=ABCDEF    # Your DLT header ID (for MSG91)

# MSG91
MSG91_AUTH_KEY=your_msg91_key
MSG91_SENDER_ID=YOURBRAND

# Twilio
TWILIO_SID=your_twilio_sid
TWILIO_AUTH_TOKEN=your_twilio_token
TWILIO_FROM=+1XXXXXXXXXX

config/sms.php

'templates' => [
    'otp' => [
        'template_id' => '1234567890',
        'body' => 'Your OTP is {{otp}}'
    ],
    'welcome' => [
        'template_id' => '654321',
        'body' => 'Hi {{name}}, welcome to our app!'
    ],
],


Usage Example

use Preeti\SmsSender\SmsManager;

$sms = new SmsManager();

// Send OTP
$sms->sendTemplate('otp', '+919999999999', ['otp' => '123456']);

// Send Welcome Message
$sms->sendTemplate('welcome', '+919999999999', ['name' => 'John']);


