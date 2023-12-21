<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Kyc
{
    public static function formDataGenerateUrl($nik,$name)
    {
        $key = base64_encode($nik.$name);
        $publicKey = "-----BEGIN PUBLIC KEY-----\n".$key."-----END PUBLIC KEY-----";
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
