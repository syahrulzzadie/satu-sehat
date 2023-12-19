<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Kyc
{
    public static function formDataGenerateUrl($nik,$name)
    {
        $publicKey = Enviroment::publicKey();
        return [
            'agent_name' => $name,
            'agent_nik' => $nik,
            'public_key' => $publicKey
        ];
    }

    public static function formDataChallengeCode($nik,$name)
    {
        return [
            'metadata' => [
                'method' => 'request_per_nik'
            ],
            'data' => [
                'nik' => $nik,
                'name' => $name
            ]
        ];
    }
}