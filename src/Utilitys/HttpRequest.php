<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class HttpRequest
{
    /**
     * Kirim request ke Satu Sehat. Jika token ditolak (401), token di-cache
     * dibuang lalu request diulang sekali dengan token baru.
     */
    private static function send($method, $url, $body, $contentType, $retry = true, $headers = [])
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
                if ($body !== null) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                }
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
                'Content-Type: '.$contentType,
                'Authorization: Bearer ' . $getToken['token']
            ], $headers));
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
                return self::send($method, $url, $body, $contentType, false, $headers);
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

    /**
     * POST JSON dengan header tambahan, mis. ['X-Encryption-Disabled: true'] untuk KPTL.
     */
    public static function postWithHeaders($url,$formData,array $headers)
    {
        return self::send('POST', $url, json_encode($formData), 'application/json', true, $headers);
    }

    public static function postTextPlain($url,$textPlain)
    {
        return self::send('POST', $url, $textPlain, 'text/plain');
    }

    public static function put($url,$formData)
    {
        return self::send('PUT', $url, json_encode($formData), 'application/json');
    }

    /**
     * JSON Patch (RFC 6902), dipakai Postman SATUSEHAT untuk ClinicalImpression,
     * CarePlan, EpisodeOfCare, Location, dll.
     */
    public static function patch($url,$operations)
    {
        return self::send('PATCH', $url, json_encode($operations), 'application/json-patch+json');
    }

    public static function delete($url)
    {
        return self::send('DELETE', $url, null, 'application/json');
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
