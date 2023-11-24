<?php

namespace syahrulzzadie\SatuSehat;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Utilitys\HttpRequest;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class SatuSehat
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
        $http = HttpRequest::postConsent($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Consent::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createEncounter($noRawat,$patient,$practitioner,$location)
    {
        $url = Url::createEncounterUrl();
        $formData = jsonData\Encounter::formCreateData($noRawat,$patient,$practitioner,$location);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounter($ihsNumber,$encounter,$status,$patient,$practitioner,$location)
    {
        $url = Url::updateEncounterUrl($ihsNumber);
        $formData = jsonData\Encounter::formUpdateData($ihsNumber,$encounter,$status,$patient,$practitioner,$location);
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

    public static function createCondition($encounter,$dataDiagnosis)
    {
        $url = Url::createConditionUrl();
        $formData = jsonData\Condition::formCreateData($encounter,$dataDiagnosis);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateCondition($ihsNumber,$encounter,$dataDiagnosis)
    {
        $url = Url::updateConditionUrl($ihsNumber);
        $formData = jsonData\Condition::formUpdateData($ihsNumber,$encounter,$dataDiagnosis);
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

    public static function createObservation($encounter,$code,$name,$value,$unit)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateData($encounter,$code,$name,$value,$unit);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateObservation($ihsNumber,$encounter,$code,$name,$value,$unit)
    {
        $url = Url::updateObservationUrl($ihsNumber);
        $formData = jsonData\Observation::formUpdateData($ihsNumber,$encounter,$code,$name,$value,$unit);
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

    public static function createComposition($encounter,$kodeDiet,$code,$name,$text)
    {
        $url = Url::createCompositionUrl();
        $formData = jsonData\Composition::formCreateData($encounter,$kodeDiet,$code,$name,$text);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateComposition($ihsNumber,$encounter,$kodeDiet,$code,$name,$text)
    {
        $url = Url::updateCompositionUrl($ihsNumber);
        $formData = jsonData\Composition::formUpdateData($ihsNumber,$encounter,$kodeDiet,$code,$name,$text);
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

    public static function createProcedure($encounter,$code,$name,$text)
    {
        $url = Url::createProcedureUrl();
        $formData = jsonData\Procedure::formCreateData($encounter,$code,$name,$text);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateProcedure($ihsNumber,$encounter,$code,$name,$text)
    {
        $url = Url::updateProcedureUrl($ihsNumber);
        $formData = jsonData\Procedure::formUpdateData($ihsNumber,$encounter,$code,$name,$text);
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

    public static function historyPatient($ihsNumber)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $token = $getToken['token'];
            $response = Http::pool(function($pool)use($token,$ihsNumber){
                $urlEncounter = Url::historyEncounterUrl($ihsNumber);
                $urlCondition = Url::historyConditionUrl($ihsNumber);
                $urlObservation = Url::historyObservationUrl($ihsNumber);
                $urlComposition = Url::historyCompositionUrl($ihsNumber);
                $urlProcedure = Url::historyProcedureUrl($ihsNumber);
                $urlMedicationRequest = Url::historyMedicationRequestUrl($ihsNumber);
                //////////////////////////////////////////////////////////////////
                HttpRequest::poolGet($pool,$token,'encounter',$urlEncounter);
                HttpRequest::poolGet($pool,$token,'condition',$urlCondition);
                HttpRequest::poolGet($pool,$token,'observation',$urlObservation);
                HttpRequest::poolGet($pool,$token,'composition',$urlComposition);
                HttpRequest::poolGet($pool,$token,'procedure',$urlProcedure);
                HttpRequest::poolGet($pool,$token,'medicationRequest',$urlMedicationRequest);
            });
            $data['encounter'] = [];
            $data['condition'] = [];
            $data['observation'] = [];
            $data['composition'] = [];
            $data['procedure'] = [];
            $data['medicationRequest'] = [];
            ///////////////////////////////////////////
            if ($response['encounter']->successful()) {
                if ($response['encounter']->status() == 200) {
                    $data['encounter'] = jsonResponse\Encounter::history($response['encounter']);
                }
            }
            if ($response['condition']->successful()) {
                if ($response['condition']->status() == 200) {
                    $data['condition'] = jsonResponse\Condition::history($response['condition']);
                }
            }
            if ($response['observation']->successful()) {
                if ($response['observation']->status() == 200) {
                    $data['observation'] = jsonResponse\Observation::history($response['observation']);
                }
            }
            if ($response['composition']->successful()) {
                if ($response['composition']->status() == 200) {
                    $data['composition'] = jsonResponse\Composition::history($response['composition']);
                }
            }
            if ($response['procedure']->successful()) {
                if ($response['procedure']->status() == 200) {
                    $data['procedure'] = jsonResponse\Procedure::history($response['procedure']);
                }
            }
            if ($response['medicationRequest']->successful()) {
                if ($response['medicationRequest']->status() == 200) {
                    $data['medicationRequest'] = jsonResponse\MedicationRequest::history($response['medicationRequest']);
                }
            }
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::getToken($getToken);
    }
}
