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
        openssl_pkey_export($rsaKey,$privateKey);
        $publicKey = openssl_pkey_get_details($rsaKey)['key'];
        return array($publicKey,$privateKey);
    }

    private static function generate_aes_key()
    {
        return base64_encode(openssl_random_pseudo_bytes(32)); // 32 bytes untuk AES-256
    }

    public static function encrypt_data_aes($publicKey,$data)
    {
        $dataJson = json_encode($data);
        $aesKey = self::generate_aes_key();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
        $encrypted = openssl_encrypt($dataJson,'aes-256-cbc',$publicKey,0,$iv);
        openssl_public_encrypt($aesKey,$encrypted,$publicKey);
        return '-----BEGIN ENCRYPTED MESSAGE-----\n'.$encrypted.'\n-----END ENCRYPTED MESSAGE-----';
    }

    public static function formDataGenerateUrl($nik,$name)
    {
        list($publicKey,$privateKey) = self::generate_rsa_key_pair();
        $data = [
            'agent_name' => $name,
            'agent_nik' => $nik,
            'public_key' => $publicKey
        ];
        return self::encrypt_data_aes($publicKey,$data);
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
