<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Practitioner
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        //$resource = $data['entry'][0]['resource'];
        return $data;
    }
}
