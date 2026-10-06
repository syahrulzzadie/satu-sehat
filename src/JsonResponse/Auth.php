<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use Exception;
use Illuminate\Support\Facades\Cache;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class Auth
{
    /**
     * Token disimpan di Cache (bukan session) supaya juga berlaku untuk route API /
     * scheduler / n8n yang tidak punya session, sehingga tidak meminta token baru
     * di setiap request ke Satu Sehat.
     */
    private static function cacheKey()
    {
        return 'satusehat_token_'.md5(Enviroment::clientId());
    }

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
            if (empty($data['access_token'])) {
                return [
                    'status' => false,
                    'message' => $data['issue'][0]['details']['text'] ?? ($data['error_description'] ?? 'Gagal mendapatkan token Satu Sehat!')
                ];
            }
            return [
                'status' => true,
                'data' => [
                    'token' => $data['access_token'],
                    'expired' => intval($data['expires_in'] ?? 3600),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public static function forgetToken()
    {
        Cache::forget(self::cacheKey());
    }

    public static function getToken() : array
    {
        $token = Cache::get(self::cacheKey());
        if ($token) {
            return [
                'status' => true,
                'token' => $token
            ];
        }
        $requestToken = self::requestToken();
        if (!$requestToken['status']) {
            return [
                'status' => false,
                'message' => $requestToken['message']
            ];
        }
        $data = $requestToken['data'];
        // Simpan dengan margin 5 menit sebelum token benar-benar kedaluwarsa
        $ttl = max(60, $data['expired'] - 300);
        Cache::put(self::cacheKey(), $data['token'], $ttl);
        return [
            'status' => true,
            'token' => $data['token']
        ];
    }
}
