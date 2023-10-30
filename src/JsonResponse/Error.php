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
}