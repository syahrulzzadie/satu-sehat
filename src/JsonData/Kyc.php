<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;
use phpseclib3\Crypt\RSA;

class Kyc
{
    private static function generateSymmetricKey()
    {
        $cryptoStrong = true;
        $key = openssl_random_pseudo_bytes(32, $cryptoStrong);
        if ($cryptoStrong !== true) {
            return null;
        }
        return $key;
    }

    private static function formatMessage($data)
    {
        $dataAsBase64 = chunk_split(base64_encode($data));
        return "-----BEGIN ENCRYPTED MESSAGE-----\r\n{$dataAsBase64}-----END ENCRYPTED MESSAGE-----";
    }

    private static function aesEncrypt($data, $symmetricKey)
    {
        $ivLength = 12;
        if (function_exists('random_bytes')) {
            $iv = random_bytes($ivLength);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $iv = openssl_random_pseudo_bytes($ivLength);
        } else {
            $iv = '';
            for ($i = 0; $i < $ivLength; $i++) {
                $iv .= chr(mt_rand(0, 255));
            }
        }
        $cipher = new AES('gcm');
        $cipher->setKeyLength(256);
        $cipher->setKey($symmetricKey);
        $cipher->setNonce($iv);
        $ciphertext = $cipher->encrypt($data);
        $tag = $cipher->getTag();
        $encryptedData = $iv.$ciphertext.$tag;
        return $encryptedData;
    }

    private static function encryptMessage($message, $pubPEM)
    {
        $aesKey = self::generateSymmetricKey();
        $serverKey = PublicKeyLoader::load($pubPEM);
        $serverKey = $serverKey->withPadding(RSA::ENCRYPTION_OAEP);
        $wrappedAesKey = $serverKey->encrypt($aesKey);
        $encryptedMessage = self::aesEncrypt($message, $aesKey);
        $payload = $wrappedAesKey.$encryptedMessage;
        return self::formatMessage($payload);
    }

    public static function formDataGenerateUrl($keyPair, $agen_nik, $agen_name)
    {
        $publicKey = $keyPair['publicKey'];
        $pubPEM = '-----BEGIN PUBLIC KEY-----
        MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxLwvebfOrPLIODIxAwFp
        4Qhksdtn7bEby5OhkQNLTdClGAbTe2tOO5Tiib9pcdruKxTodo481iGXTHR5033I
        A5X55PegFeoY95NH5Noj6UUhyTFfRuwnhtGJgv9buTeBa4pLgHakfebqzKXr0Lce
        /Ff1MnmQAdJTlvpOdVWJggsb26fD3cXyxQsbgtQYntmek2qvex/gPM9Nqa5qYrXx
        8KuGuqHIFQa5t7UUH8WcxlLVRHWOtEQ3+Y6TQr8sIpSVszfhpjh9+Cag1EgaMzk+
        HhAxMtXZgpyHffGHmPJ9eXbBO008tUzrE88fcuJ5pMF0LATO6ayXTKgZVU0WO/4e
        iQIDAQAB
        -----END PUBLIC KEY-----';
        $data = [
            'agent_name' => $agen_name,
            'agent_nik' => $agen_nik,
            'public_key' => $publicKey
        ];
        $jsonData = json_encode($data);
        $encryptedPayload = self::encryptMessage($jsonData, $pubPEM);
        return $encryptedPayload;
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
