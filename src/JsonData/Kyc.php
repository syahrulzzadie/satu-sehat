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
        $data = "-----BEGIN ENCRYPTED MESSAGE-----\n";
        $data .= self::encriptGeneralUrl($nik,$name);
        $data .= "\n-----END ENCRYPTED MESSAGE-----";
        return $data;
    }

    private static function encriptChallengeCode($nik,$name)
    {
        $data = [
            'metadata' => [
                'method' => 'request_per_nik'
            ],
            'data' => [
                'nik' => $nik,
                'name' => $name
            ]
        ];
        $jsonData = json_encode($data);
        return base64_encode($jsonData);
    }

    public static function formDataChallengeCode($nik,$name)
    {
        $data = "-----BEGIN ENCRYPTED MESSAGE-----\n";
        $data .= self::encriptChallengeCode($nik,$name);
        $data .= "\n-----END ENCRYPTED MESSAGE-----";
        return $data;
    }
}