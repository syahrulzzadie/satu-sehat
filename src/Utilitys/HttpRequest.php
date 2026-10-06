<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class HttpRequest
{
    /**
     * Kirim request ke Satu Sehat. Jika token ditolak (401), token di-cache
     * dibuang lalu request diulang sekali dengan token baru.
     */
    private static function send($method, $url, $body, $contentType, $retry = true)
    {
        $getToken = jsonResponse\Auth::getToken();
        if (!$getToken['status']) {
            return jsonResponse\Error::getToken($getToken);
        }
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            if ($method == 'GET') {
                curl_setopt($ch, CURLOPT_HTTPGET, true);
            } else if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: '.$contentType,
                'Authorization: Bearer ' . $getToken['token']
            ]);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $message = curl_error($ch);
                curl_close($ch);
                return [
                    'status' => false,
                    'message' => $message
                ];
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpCode == 401 && $retry) {
                jsonResponse\Auth::forgetToken();
                return self::send($method, $url, $body, $contentType, false);
            }
            return [
                'status' => true,
                'response' => $response
            ];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public static function get($url)
    {
        return self::send('GET', $url, null, 'application/x-www-form-urlencoded');
    }

    public static function post($url,$formData)
    {
        return self::send('POST', $url, json_encode($formData), 'application/json');
    }

    public static function postTextPlain($url,$textPlain)
    {
        return self::send('POST', $url, $textPlain, 'text/plain');
    }

    public static function put($url,$formData)
    {
        return self::send('PUT', $url, json_encode($formData), 'application/json');
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
