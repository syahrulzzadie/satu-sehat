<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class Enviroment
{
    public static function clientId()
    {
        $code = strrev(Constant::$clientId);
        return base64_decode($code);
    }

    public static function clientSecret()
    {
        $code = strrev(Constant::$clientSecret);
        return base64_decode($code);
    }

    public static function organizationId()
    {
        $code = strrev(Constant::$organizationId);
        return base64_decode($code);
    }

    public static function publicKey()
    {
        return base64_encode('satu-sehat');
    }
}