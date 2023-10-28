<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

define('_authUrl_','https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1');
define('_baseUrl_','https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1');
define('_clientId_','GNcAwDI0rtlyAtKT2Jl1NfnJELosLrGAWsSIaaglYttqVT0i');
define('_clientSecret_','004GXxQtTOQSEAcJe32pBPDnpxOWf4gevgOAIHdCEXOoLpKwZhYeFC4H9UGLBmHe');
define('_organizationId_','b89d3141-07d2-4c00-8f00-7b0f9965cb02');

class Auth
{
    private static function requestToken() : array
    {
        $url = _authUrl_.'/accesstoken?grant_type=client_credentials';
        $data['client_id'] = _clientId_;
        $data['client_secret'] = _clientSecret_;
        $response = Http::asForm()->post($url,$data);
        if ($response->successful()) {
            if ($response->status() == 200) {
                $data = json_decode($response->body(),true);
                return [
                    'status' => true,
                    'data' => [
                        'token' => $data['access_token'],
                        'expired' => $data['expires_in'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Error generate token!'
        ];
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
            $diff = now()->diffInSeconds(Carbon::parse($createdAt));
            $expired = intval($expired - 60);
            if ($diff >= $expired) {
                $generate = self::requestToken();
                if ($generate['status']) {
                    $generateData = $generate['data'];
                    return [
                        'status' => true,
                        'data' => [
                            'token' => $generateData['token']
                        ]
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
