<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use DateTime;
use Exception;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class Auth
{
    private static function requestToken() : array
    {
        try {
            $url = Url::authUrl();
            $data['client_id'] = Enviroment::clientId();
            $data['client_secret'] = Enviroment::clientSecret();
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                return [
                    'status' => false,
                    'message' => curl_error($ch)
                ];
            }
            curl_close($ch);
            $data = json_decode($response,true);
            return [
                'status' => true,
                'data' => [
                    'token' => $data['access_token'],
                    'expired' => $data['expires_in'],
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    private static function generateToken() : array
    {
        $requestToken = self::requestToken();
        if ($requestToken['status']) {
            $data = $requestToken['data'];
            session()->put('satusehat_token_key',$data['token']);
            session()->put('satusehat_token_exp',$data['expired']);
            session()->put('satusehat_token_created_at',$data['created_at']);
            return [
                'status' => true,
                'data' => [
                    'token' => $data['token']
                ]
            ];
        }
        return [
            'status' => false,
            'message' => $requestToken['message']
        ];
    }

    private static function getDiffSecond($dateTime)
    {
        $datetime = new DateTime($dateTime);
        $current_datetime = new DateTime();
        $interval = $current_datetime->diff($datetime);
        $seconds_difference = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);
        return intval($seconds_difference);
    }

    public static function getToken() : array
    {
        $token = session('satusehat_token_key',false);
        $expired = session('satusehat_token_exp',false);
        $createdAt = session('satusehat_token_created_at',false);
        if (!$token && !$expired && !$createdAt) {
            $generate = self::generateToken();
            if ($generate['status']) {
                $data = $generate['data'];
                return [
                    'status' => true,
                    'token' => $data['token']
                ];
            } else {
                return [
                    'status' => false,
                    'message' => $generate['message']
                ];
            }
        } else {
            $diff = self::getDiffSecond($createdAt);
            $expired = intval($expired - 60);
            if ($diff >= $expired) {
                $generate = self::requestToken();
                if ($generate['status']) {
                    $generateData = $generate['data'];
                    return [
                        'status' => true,
                        'token' => $generateData['token']
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => $generate['message']
                    ];
                }
            } else {
                $generate = self::generateToken();
                if ($generate['status']) {
                    $data = $generate['data'];
                    return [
                        'status' => true,
                        'token' => $data['token']
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => $generate['message']
                    ];
                }
            }
        }
    }
}
