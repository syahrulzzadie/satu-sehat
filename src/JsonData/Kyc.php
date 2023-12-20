<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Kyc
{
    private static function generateRSAkey()
    {
        $privateKey = 'satu-sehat';
        $rsaKey = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ]);
        openssl_pkey_export($rsaKey, $privateKey);
        $publicKeyDetails = openssl_pkey_get_details($rsaKey);
        $publicKey = $publicKeyDetails['key'];
        return [
            'private_key' => $privateKey,
            'public_key' => $publicKey
        ];
    }

    private static function getAESkey()
    {
        return bin2hex(random_bytes(16));
    }

    private static function encryptDataAES($data)
    {
        $generateRSAkey = self::generateRSAkey();
        $publicKey = $generateRSAkey['public_key'];
        $rsaPublicKey = "-----BEGIN PUBLIC KEY-----
        ".$publicKey."
        -----END PUBLIC KEY-----";
        $aesKey = self::getAESkey();
        $message = json_encode($data);
        $encryptedMessage = openssl_public_encrypt($message, $encrypted, $rsaPublicKey, OPENSSL_PKCS1_PADDING);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
        $encryptedMessageAES = openssl_encrypt($encrypted, "aes-256-cbc", $aesKey, 0, $iv);
        return $encryptedMessageAES;
    }

    private static function encryptGeneralUrl($nik,$name)
    {
        $generateRSAkey = self::generateRSAkey();
        $publicKey = $generateRSAkey['public_key'];
        $data = [
            'agent_name' => $name,
            'agent_nik' => $nik,
            'public_key' => $publicKey
        ];
        return self::encryptDataAES($data);
    }

    public static function formDataGenerateUrl($nik,$name)
    {
        return "-----BEGIN ENCRYPTED MESSAGE-----
        ".self::encryptGeneralUrl($nik,$name)."
        -----END ENCRYPTED MESSAGE-----";
    }

    private static function encryptChallengeCode($nik,$name)
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
        return self::encryptDataAES($jsonData);
    }

    public static function formDataChallengeCode($nik,$name)
    {
        return "-----BEGIN ENCRYPTED MESSAGE-----
        ".self::encryptChallengeCode($nik,$name)."
        -----END ENCRYPTED MESSAGE-----";
    }
}
