<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Kyc
{
    private static function generate_rsa_key_pair()
    {
        $config = array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $rsaKey = openssl_pkey_new($config);
        openssl_pkey_export($rsaKey, $privateKey);
        $publicKey = openssl_pkey_get_details($rsaKey)['key'];
        return array($publicKey, $privateKey);
    }

    private static function generate_aes_key()
    {
        return base64_encode(openssl_random_pseudo_bytes(32));
    }

    private static function encrypt_message_rsa_aes($data) {
        list($publicKey, $privateKey) = self::generate_rsa_key_pair();
        $aesKey = self::generate_aes_key();
        openssl_public_encrypt($data,$aesKey,$publicKey);
    }

    public static function formDataGenerateUrl($nik,$name)
    {
        list($publicKey,) = self::generate_rsa_key_pair();
        return [
            'agent_name' => $name,
            'agent_nik' => $nik,
            'public_key' => '-----BEGIN PUBLIC KEY-----\n'.$publicKey.'\n-----END PUBLIC KEY-----'
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
