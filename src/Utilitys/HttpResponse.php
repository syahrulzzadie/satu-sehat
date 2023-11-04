<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class HttpResponse
{
    public static function get($url)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $response = Http::asForm()
                ->timeout(300)
                ->retry(5,1000)
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    return [
                        'status' => true,
                        'response' => $response
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function post($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $response = Http::timeout(300)
                ->retry(5,1000)
                ->withToken($getToken['token'])
                ->post($url,$formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    return [
                        'status' => true,
                        'response' => $response
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function postConsent($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $response = Http::timeout(300)
                ->retry(5,1000)
                ->withToken($getToken['token'])
                ->post($url,$formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    return [
                        'status' => true,
                        'response' => $response
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function put($url,$formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $response = Http::timeout(300)
                ->retry(5,1000)
                ->withToken($getToken['token'])
                ->put($url,$formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    return [
                        'status' => true,
                        'response' => $response
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }
}