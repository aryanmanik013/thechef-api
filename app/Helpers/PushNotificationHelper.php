<?php

namespace App\Helpers;

use App\Model\PushNotification;
use GuzzleHttp\Client;

// use Illuminate\Support\Facades\Http;
// use Illuminate\Http\Client\Response;

class PushNotificationHelper
{

    public static function notify($title, $body, $params, $user, $route, $user_type)
    {

        $token = PushNotification::whereIn('user_id', $user)->where('user_type', $user_type)->get()->pluck('token');

        if (!empty($token) && count($token)) {

            $data = [
                'params' => $params,
                'route' => $route,
                'body' => $body,
            ];
            $client = new Client();
            $response = $client->request('POST', 'https://exp.host/--/api/v2/push/send', [
                'json' => [
                    'to' => $token->toArray(),
                    'title' => $title,
                    // 'subtitle' => 'GheeRice',
                    'body' => $body,
                    'data' => json_encode($data),
                    'priority' => 'default',
                    'sound' => 'default',
                    'android' => [
                        'priority' => 'max',
                        'sound' => 'true',
                        'vibrate' => [0, 250, 250, 250],
                        'color' => '#FF0000',
                    ],
                ],

                'headers' => [
                    'host' => 'exp.host',
                    'accept' => 'application/json',
                    'accept-encoding' => 'gzip, deflate',
                    'content-type' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                return true;
            } else {
                return false;
            }
        }
    }
    public static function notifyAll($title, $body, $params, $token, $route, $user_type)
    {

        $token = PushNotification::where('user_type', $user_type)->get()->pluck('token');

        if (!empty($token) && count($token)) {
            $data = [
                'params' => $params,
                'route' => $route,
                'body' => $body,
            ];
            $client = new Client();
            $response = $client->request('POST', 'https://exp.host/--/api/v2/push/send', [
                'json' => [
                    'to' => $token->toArray(),
                    'title' => $title,

                    'body' => $body,
                    'data' => json_encode($data),
                    'priority' => 'default',
                    'sound' => 'default',
                    'android' => [
                        'priority' => 'max',
                        'sound' => 'true',
                        'vibrate' => [0, 250, 250, 250],
                        'color' => '#FF0000',
                    ],
                ],

                'headers' => [
                    'host' => 'exp.host',
                    'accept' => 'application/json',
                    'accept-encoding' => 'gzip, deflate',
                    'content-type' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                return true;
            } else {
                return false;
            }
        }
    }
}
