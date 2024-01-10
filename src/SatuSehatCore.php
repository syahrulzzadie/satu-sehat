<?php

namespace syahrulzzadie\SatuSehat;

use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Utilitys\HttpRequest;
use syahrulzzadie\SatuSehat\Utilitys\Security;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class SatuSehatCore
{
    public static function getPatientByNik($nik)
    {
        $url = Url::patientUrl($nik);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Patient::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function getPractitionerByNik($nik)
    {
        $url = Url::practitionerUrl($nik);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Practitioner::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function showOrganization()
    {
        $url = Url::showOrganizationUrl();
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::show($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createOrganization($kode, $name)
    {
        $url = Url::createOrganizationUrl();
        $formData = jsonData\Organization::formCreateData($kode,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateOrganization($ihsNumber, $kode, $name)
    {
        $url = Url::updateOrganizationUrl($ihsNumber);
        $formData = jsonData\Organization::formUpdateData($ihsNumber,$kode,$name);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function showLocation($ihsNumberOrganization)
    {
        $url = Url::showLocationUrl($ihsNumberOrganization);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::show($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createLocation($organization,$kode,$name)
    {
        $url = Url::createLocationUrl();
        $formData = jsonData\Location::formCreateData($organization,$kode,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateLocation($ihsNumber,$organization,$kode,$name)
    {
        $url = Url::updateLocationUrl($ihsNumber);
        $formData = jsonData\Location::formUpdateData($ihsNumber,$organization,$kode,$name);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateConsent($ihsNumber,$petugas,$status)
    {
        $url = Url::updateConsentPatientUrl();
        $formData = jsonData\Consent::formData($ihsNumber,$petugas,$status);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Consent::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createEncounter($noRawat,$date,$time,$patient,$practitioner,$location)
    {
        $url = Url::createEncounterUrl();
        $formData = jsonData\Encounter::formCreateData($noRawat,$date,$time,$patient,$practitioner,$location);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounter($encounter,$patient,$practitioner,$location)
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formUpdateData($encounter,$patient,$practitioner,$location);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function cancelEncounter($encounter,$patient,$practitioner,$location)
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formCancelData($encounter,$patient,$practitioner,$location);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounterCondition($encounter,$dataDiagnosa)
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formUpdateCondition($encounter,$dataDiagnosa);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyEncounter($ihsNumberPatient)
    {
        $url = Url::historyEncounterUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createCondition($encounter,$code,$name)
    {
        $url = Url::createConditionUrl();
        $formData = jsonData\Condition::formCreateData($encounter,$code,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateCondition($ihsNumber,$encounter,$code,$name)
    {
        $url = Url::updateConditionUrl($ihsNumber);
        $formData = jsonData\Condition::formUpdateData($ihsNumber,$encounter,$code,$name);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyCondition($ihsNumberPatient)
    {
        $url = Url::historyConditionUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createObservation($encounter,$practitioner,$name,$value)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateData($encounter,$practitioner,$name,$value);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateObservation($ihsNumber,$encounter,$practitioner,$name,$value)
    {
        $url = Url::updateObservationUrl($ihsNumber);
        $formData = jsonData\Observation::formUpdateData($ihsNumber,$encounter,$practitioner,$name,$value);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyObservation($ihsNumberPatient)
    {
        $url = Url::historyObservationUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createComposition($encounter,$noRawat,$code,$name,$text)
    {
        $url = Url::createCompositionUrl();
        $formData = jsonData\Composition::formCreateData($encounter,$noRawat,$code,$name,$text);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateComposition($ihsNumber,$encounter,$noRawat,$code,$name,$text)
    {
        $url = Url::updateCompositionUrl($ihsNumber);
        $formData = jsonData\Composition::formUpdateData($ihsNumber,$encounter,$noRawat,$code,$name,$text);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyComposition($ihsNumberPatient)
    {
        $url = Url::historyCompositionUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createProcedure($encounter, $procedureCode, $procedureName)
    {
        $url = Url::createProcedureUrl();
        $formData = jsonData\Procedure::formCreateData($encounter, $procedureCode, $procedureName);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateProcedure($ihsNumber, $encounter, $procedureCode, $procedureName)
    {
        $url = Url::updateProcedureUrl($ihsNumber);
        $formData = jsonData\Procedure::formUpdateData($ihsNumber, $encounter, $procedureCode, $procedureName);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyProcedure($ihsNumberPatient)
    {
        $url = Url::historyProcedureUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createMedication($encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat)
    {
        $url = Url::createMedicationUrl();
        $formData = jsonData\Medication::formCreateData($encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Medication::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateMedication($ihsNumber,$encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat)
    {
        $url = Url::updateMedicationUrl($ihsNumber);
        $formData = jsonData\Medication::formUpdateData($ihsNumber,$encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Medication::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createMedicationRequest($encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis)
    {
        $url = Url::createMedicationRequestUrl();
        $formData = jsonData\MedicationRequest::formCreateData($encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateMedicationRequest($ihsNumber,$encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis)
    {
        $url = Url::updateMedicationRequestUrl($ihsNumber);
        $formData = jsonData\MedicationRequest::formUpdateData($ihsNumber,$encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyMedicationRequest($ihsNumberPatient)
    {
        $url = Url::historyMedicationRequestUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function searchProductsByCode($code)
    {
        $url = Url::searchProductsByCode($code);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kfa::convertByCode($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function searchProductsByType($type,$start = 1,$limit = 10)
    {
        $url = Url::searchProductsByType($type,$start,$limit);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kfa::convertByType($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function KycGenerateUrl($nik,$name)
    {
        $url = Url::kycGenerateUrl();
        $keyPair = Security::generateKey();
        $formData = jsonData\Kyc::formDataGenerateUrl($keyPair,$nik,$name);
        $http = HttpRequest::postTextPlain($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kyc::convertGenerateUrl($keyPair,$response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function KycChallengeCode($nik,$name)
    {
        $url = Url::kycChallengeCode();
        $formData = jsonData\Kyc::formDataChallengeCode($nik,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kyc::convertChallengeCode($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyPatient($ihsNumber)
    {
        $dataHistory = [];
        $urls['encounter'] = Url::historyEncounterUrl($ihsNumber);
        $urls['condition'] = Url::historyConditionUrl($ihsNumber);
        $urls['observation'] = Url::historyObservationUrl($ihsNumber);
        $urls['composition'] = Url::historyCompositionUrl($ihsNumber);
        $urls['procedure'] = Url::historyProcedureUrl($ihsNumber);
        $urls['medicationRequest'] = Url::historyMedicationRequestUrl($ihsNumber);
        ////////////////////////////////////
        $gets = HttpRequest::poolGet($urls);
        /////////////////////////////////////
        $getEncounter = $gets['encounter'];
        if ($getEncounter['status']) {
            $dataHistory['encounter'] = jsonResponse\Encounter::history($getEncounter['response']);
        }
        $getCondition = $gets['condition'];
        if ($getCondition['status']) {
            $dataHistory['condition'] = jsonResponse\Condition::history($getCondition['response']);
        }
        $getObservation = $gets['observation'];
        if ($getObservation['status']) {
            $dataHistory['observation'] = jsonResponse\Observation::history($getObservation['response']);
        }
        $getComposition = $gets['composition'];
        if ($getComposition['status']) {
            $dataHistory['composition'] = jsonResponse\Composition::history($getComposition['response']);
        }
        $getProcedure = $gets['procedure'];
        if ($getProcedure['status']) {
            $dataHistory['procedure'] = jsonResponse\Procedure::history($getProcedure['response']);
        }
        $getMedicationRequest = $gets['medicationRequest'];
        if ($getMedicationRequest['status']) {
            $dataHistory['medicationRequest'] = jsonResponse\MedicationRequest::history($getMedicationRequest['response']);
        }
        /////////////////////
        return $dataHistory;
    }
}
