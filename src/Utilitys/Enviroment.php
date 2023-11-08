<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class Enviroment
{
    public static function clientId()
    {
        $code = base64_decode(Constant::$clientId);
        return strrev($code);
    }

    public static function clientSecret()
    {
        $code = base64_decode(Constant::$clientSecret);
        return strrev($code);
    }

    public static function organizationId()
    {
        $code = base64_decode(Constant::$organizationId);
        return strrev($code);
    }
}