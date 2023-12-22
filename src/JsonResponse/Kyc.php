<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;
use phpseclib3\Crypt\RSA;

class Kyc
{
    private static function generateKey()
    {
        $config = [
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ];
        $keyPair = openssl_pkey_new($config);
        $publicKey = openssl_pkey_get_details($keyPair)['key'];
        openssl_pkey_export($keyPair, $privateKey);
        return [
            'publicKey' => $publicKey,
            'privateKey' => $privateKey,
        ];
    }

    private static function aesDecrypt($encryptedData, $symmetricKey)
    {
        $cipher = 'aes-256-gcm';
        $ivlen = openssl_cipher_iv_length($cipher);
        $tag_length = 16;
        $iv = substr($encryptedData,0,$ivlen);
        $tag = substr($encryptedData,-$tag_length);
        $ciphertext = substr($encryptedData,$ivlen,-$tag_length);
        $ciphertext_raw = openssl_decrypt($ciphertext, $cipher, $symmetricKey, OPENSSL_NO_PADDING, $iv, $tag);
        return $ciphertext_raw;
    }

    private static function decryptMessage($message, $privateKey)
    {
        $beginTag = '-----BEGIN ENCRYPTED MESSAGE-----';
        $endTag = '-----END ENCRYPTED MESSAGE-----';
        $messageContents = substr(
            $message,
            strlen($beginTag) + 1,
            strlen($message) - strlen($endTag) - strlen($beginTag) - 2
        );
        $binaryDerString = base64_decode($messageContents);
        $wrappedKeyLength = 256;
        $wrappedKey = substr($binaryDerString, 0, $wrappedKeyLength);
        $encryptedMessage = substr($binaryDerString, $wrappedKeyLength);
        $key = PublicKeyLoader::load($privateKey);
        $aesKey = $key->decrypt($wrappedKey);
        return self::aesDecrypt($encryptedMessage, $aesKey);
    }

    public static function convertGenerateUrl($response) : array
    {
        $keyPair = self::generateKey();
        $privateKey = $keyPair['privateKey'];
        $response = self::decryptMessage($response, $privateKey);
        $data = json_decode($response,true);
        $cekMetadata = isset($data['metadata']);
        if ($cekMetadata) {
            $code = $data['metadata']['code'];
            if (intval($code) == 200) {
                return [
                    'status' => true,
                    'data' => $data['data']
                ];
            }
            return [
                'status' => false,
                'message' => $data['metadata']['message']
            ];
        }
        return [
            'status' => false,
            'message' => 'Error get generate url'
        ];
    }

    public static function convertChallengeCode($response) : array
    {
        $data = json_decode($response,true);
        $cekMetadata = isset($data['metadata']);
        if ($cekMetadata) {
            $code = $data['metadata']['code'];
            if (intval($code) == 200) {
                return [
                    'status' => true,
                    'data' => $data['data']
                ];
            }
            return [
                'status' => false,
                'message' => $data['metadata']['message']
            ];
        }
        return [
            'status' => false,
            'message' => 'Error get challenge code'
        ];
    }
}