<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Kyc
{
    private static function encriptGeneralUrl($nik,$name)
    {
        $publicKey = Enviroment::publicKey();
        $data = [
            'agent_name' => $name,
            'agent_nik' => $nik,
            'public_key' => $publicKey
        ];
        $jsonData = json_encode($data);
        return base64_encode($jsonData);
    }

    public static function formDataGenerateUrl($nik,$name)
    {
        return "-----BEGIN ENCRYPTED MESSAGE-----
        ".self::encriptGeneralUrl($nik,$name)."
        -----END ENCRYPTED MESSAGE-----";
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