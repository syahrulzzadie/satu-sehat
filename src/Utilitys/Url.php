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

    private static function consentUrl($subUrl)
    {
        return Constant::$consentUrl.'/'.$subUrl;
    }

    private static function kfaUrl($subUrl)
    {
        return Constant::$kfaUrl.'/'.$subUrl;
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

    public static function showOrganizationUrl()
    {
        $organizationId = Enviroment::organizationId();
        return self::baseUrl('Organization?partof='.$organizationId);
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
        return self::consentUrl('Consent?patient_id='.$ihsNumber);
    }

    public static function updateConsentPatientUrl()
    {
        return self::consentUrl('Consent');
    }

    public static function createEncounterUrl()
    {
        return self::baseUrl('Encounter');
    }

    public static function updateEncounterUrl($ihsNumber)
    {
        return self::baseUrl('Encounter/'.$ihsNumber);
    }

    public static function historyEncounterUrl($ihsNumberPatient)
    {
        return self::baseUrl('Encounter?subject='.$ihsNumberPatient);
    }

    public static function createConditionUrl()
    {
        return self::baseUrl('Condition');
    }

    public static function updateConditionUrl($ihsNumber)
    {
        return self::baseUrl('Condition/'.$ihsNumber);
    }

    public static function historyConditionUrl($ihsNumberPatient)
    {
        return self::baseUrl('Condition?subject='.$ihsNumberPatient);
    }

    public static function createObservationUrl()
    {
        return self::baseUrl('Observation');
    }

    public static function updateObservationUrl($ihsNumber)
    {
        return self::baseUrl('Observation/'.$ihsNumber);
    }

    public static function historyObservationUrl($ihsNumberPatient)
    {
        return self::baseUrl('Observation?subject='.$ihsNumberPatient);
    }

    public static function createCompositionUrl()
    {
        return self::baseUrl('Composition');
    }

    public static function updateCompositionUrl($ihsNumber)
    {
        return self::baseUrl('Composition/'.$ihsNumber);
    }

    public static function historyCompositionUrl($ihsNumberPatient)
    {
        return self::baseUrl('Composition?subject='.$ihsNumberPatient);
    }

    public static function createProcedureUrl()
    {
        return self::baseUrl('Procedure');
    }

    public static function updateProcedureUrl($ihsNumber)
    {
        return self::baseUrl('Procedure/'.$ihsNumber);
    }

    public static function historyProcedureUrl($ihsNumberPatient)
    {
        return self::baseUrl('Procedure?subject='.$ihsNumberPatient);
    }

    public static function createMedicationUrl()
    {
        return self::baseUrl('Medication');
    }

    public static function updateMedicationUrl($ihsNumber)
    {
        return self::baseUrl('Medication/'.$ihsNumber);
    }

    public static function createMedicationRequestUrl()
    {
        return self::baseUrl('MedicationRequest');
    }

    public static function updateMedicationRequestUrl($ihsNumber)
    {
        return self::baseUrl('MedicationRequest/'.$ihsNumber);
    }

    public static function historyMedicationRequestUrl($ihsNumberPatient)
    {
        return self::baseUrl('MedicationRequest?subject='.$ihsNumberPatient);
    }

    public static function searchProductsByCode($code)
    {
        return self::kfaUrl('products?identifier=kfa&code='.$code);
    }

    public static function searchProductsByType($type,$start = 1,$limit = 10)
    {
        return self::kfaUrl('products/all?page='.$start.'&size='.$limit.'&product_type=farmasi'.$type);
    }
}