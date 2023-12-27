<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class HttpRequest
{
    public static function get($url)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function post($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($formData));
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function postTextPlain($url,$textPlain)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: text/plain',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$textPlain);
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function put($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($formData));
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function poolGet($urls = [])
    {
        $responses = [];
        foreach ($urls as $name => $url) {
            $responses[$name] = self::get($url);
        }
        return $responses;
    }
}
