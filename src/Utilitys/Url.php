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

    private static function hostUrl($subUrl)
    {
        return Constant::$host.'/'.$subUrl;
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

    public static function createOrganizationUrl()
    {
        return self::baseUrl('Organization');
    }

    public static function updateOrganizationUrl($ihsNumber)
    {
        return self::baseUrl('Organization/'.$ihsNumber);
    }

    public static function createLocationUrl()
    {
        return self::baseUrl('Location');
    }

    public static function updateLocationUrl($ihsNumber)
    {
        return self::baseUrl('Location/'.$ihsNumber);
    }

    public static function getConsentPatientUrl($ihsNumber)
    {
        return self::hostUrl('consent/v1/Consent?patient_id='.$ihsNumber);
    }

    public static function updateConsentPatientUrl()
    {
        return self::hostUrl('consent/v1/Consent');
    }

    public static function createEcounterUrl()
    {
        return self::baseUrl('Ecounter');
    }

    public static function updateEcounterUrl($ihsNumber)
    {
        return self::baseUrl('Ecounter/'.$ihsNumber);
    }
}