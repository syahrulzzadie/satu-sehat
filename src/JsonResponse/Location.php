<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Location
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        return [
            'ihs_number' => $data['id'],
            'name' => $data['name']
        ];
    }
}