<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class SmsHelper
{
    public static function send(string $mobile, string $message)
    {
        $client = new Client();
        $response = $client->request('GET', env('SMS_API_URL', 'https://api-alerts.kaleyra.com/v4/'), [
            'query' => ['api_key' => env('SMS_API_KEY', null),
                'to' => $mobile,
                'method' => env('SMS_METHOD', 'SMS'),
                'sender' => env('SMS_SENDER_NAME', 'Avaron'),
                'message' => $message,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            return false;
        }
    }
    public static function sendAll($mobile, string $message)
    {

        for ($i = 0; $i < count($mobile) - 1; $i++) {
            $client = new Client();
            $response = $client->request('GET', env('SMS_API_URL', 'https://api-alerts.kaleyra.com/v4/'), [
                'query' => ['api_key' => env('SMS_API_KEY', null),
                    'to' => $mobile[$i],
                    // 'to'=>$phoneArray[$i],
                    'method' => env('SMS_METHOD', 'SMS'),
                    'sender' => env('SMS_SENDER_NAME', 'Avaron'),
                    'message' => $message,
                ],
            ]);
        }
        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            return false;
        }
    }
}
