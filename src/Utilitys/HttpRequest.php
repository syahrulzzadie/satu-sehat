<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class HttpRequest
{
    private static function handleResponse($response)
    {
        if ($response->successful()) {
            $responseBody = json_decode($response->body(),true);
            return ['status' => true, 'response' => $responseBody];
        }
        if ($response->failed()) {
            return ['status' => false, 'message' => 'Failed get request!'];
        }
        if ($response->clientError()) {
            return ['status' => false, 'message' => 'Client error!'];
        }
        if ($response->serverError()) {
            return ['status' => false, 'message' => 'Server error!'];
        }
        return jsonResponse\Error::response($response);
    }

    public static function get($url)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $response = Http::asForm()
                    ->timeout(300)
                    ->retry(5,1000)
                    ->withToken($getToken['token'])
                    ->get($url);
                return self::handleResponse($response);
            } catch (\Exception $e) {
                return ['status' => false, 'message' => 'Unknown error!'];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function post($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $response = Http::timeout(300)
                    ->retry(5,1000)
                    ->withToken($getToken['token'])
                    ->post($url,$formData);
                return self::handleResponse($response);
            } catch (\Exception $e) {
                return ['status' => false, 'message' => 'Unknown error!'];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function postConsent($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $response = Http::timeout(300)
                    ->retry(5,1000)
                    ->withToken($getToken['token'])
                    ->post($url,$formData);
                return self::handleResponse($response);
            } catch (\Exception $e) {
                return ['status' => false, 'message' => 'Unknown error!'];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function put($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $response = Http::timeout(300)
                    ->retry(5,1000)
                    ->withToken($getToken['token'])
                    ->put($url,$formData);
                return self::handleResponse($response);
            } catch (\Exception $e) {
                return ['status' => false, 'message' => 'Unknown error!'];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function poolGet($pool,$token,$as,$url)
    {
        return $pool->as($as)
            ->asForm()
            ->timeout(300)
            ->retry(5,1000)
            ->withToken($token)
            ->get($url);
    }
}