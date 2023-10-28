<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class Url
{
    private static function authHost($subUrl)
    {
        return Constant::$authUrl.'/'.$subUrl;
    }

    private static function baseUrl($subUrl)
    {
        return Constant::$baseUrl.'/'.$subUrl;
    }

    public static function authUrl()
    {
        return self::authHost('accesstoken?grant_type=client_credentials');
    }

    public static function patientUrl($nik)
    {
        return self::baseUrl('Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik);
    }

    public static function practitionerUrl($nik)
    {
        return self::baseUrl('Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik);
    }
}