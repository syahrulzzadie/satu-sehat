<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;
use phpseclib3\Crypt\RSA;

class Security {

    public static function generateKey()
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
}