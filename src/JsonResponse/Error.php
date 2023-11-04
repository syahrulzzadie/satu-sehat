<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Error
{
    public static function response($response)
    {
        $message = json_encode($response->body());
        return [
            'status' => false,
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

    public static function http($http)
    {
        return [
            'status' => false,
            'message' => $http['message']
        ];
    }
}