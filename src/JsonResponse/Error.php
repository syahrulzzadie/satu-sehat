<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Error
{
    public static function response($response)
    {
        $message = json_encode($response->body());
        return [
            'status' => false,
            'code' => $response->status(),
            'message' => $message
        ];
    }

    public static function getToken($getToken)
    {
        return [
            'status' => false,
            'message' => $getToken['message']
        ];
    }
}