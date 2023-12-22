<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

defined('_SATUSEHAT_CLIENT_ID_') or die('Satu Sehat Client Id is required!');
defined('_SATUSEHAT_CLIENT_SECRET_') or die('Satu Sehat Client Secret is required!');
defined('_SATUSEHAT_ORGANIZATION_ID_') or die('Satu Sehat Organization Id is required!');

class Enviroment
{
    public static function clientId()
    {
        return _SATUSEHAT_CLIENT_ID_;
    }

    public static function clientSecret()
    {
        return _SATUSEHAT_CLIENT_SECRET_;
    }

    public static function organizationId()
    {
        return _SATUSEHAT_ORGANIZATION_ID_;
    }
}