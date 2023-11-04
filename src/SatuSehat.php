<?php

namespace syahrulzzadie\SatuSehat;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Utilitys\HttpResponse;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class SatuSehat
{
    public static function getPatientByNik($nik)
    {
        $url = Url::patientUrl($nik);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Patient::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function getPractitionerByNik($nik)
    {
        $url = Url::practitionerUrl($nik);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Practitioner::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function createOrganization($name)
    {
        $url = Url::createOrganizationUrl();
        $formData = jsonData\Organization::formCreateData($name);
        $http = HttpResponse::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Organization::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateOrganization($ihsNumber, $name)
    {
        $url = Url::updateOrganizationUrl($ihsNumber);
        $formData = jsonData\Organization::formUpdateData($ihsNumber,$name);
        $http = HttpResponse::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Organization::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function createLocation($organization,$name)
    {
        $url = Url::createLocationUrl();
        $formData = jsonData\Location::formCreateData($organization,$name);
        $http = HttpResponse::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Location::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateLocation($ihsNumber,$organization,$name)
    {
        $url = Url::updateLocationUrl($ihsNumber);
        $formData = jsonData\Location::formUpdateData($ihsNumber,$organization,$name);
        $http = HttpResponse::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Location::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function getConsent($ihsNumber)
    {
        $url = Url::getConsentPatientUrl($ihsNumber);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Consent::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateConsent($ihsNumber,$petugas,$status)
    {
        $url = Url::updateConsentPatientUrl();
        $formData = jsonData\Consent::formData($ihsNumber,$petugas,$status);
        $http = HttpResponse::postConsent($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Consent::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function createEncounter($noRm,$noRawat,$organization,$patient,$practitioner,$location)
    {
        $url = Url::createEncounterUrl();
        $formData = jsonData\Encounter::formCreateData($noRm,$noRawat,$organization,$patient,$practitioner,$location);
        $http = HttpResponse::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Encounter::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounter($ihsNumber,$status,$createdAt,$noRm,$noRawat,$organization,$patient,$practitioner,$location)
    {
        $url = Url::updateEncounterUrl($ihsNumber);
        $formData = jsonData\Encounter::formUpdateData($ihsNumber,$status,$createdAt,$noRm,$noRawat,$organization,$patient,$practitioner,$location);
        $http = HttpResponse::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Encounter::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyEncounter($ihsNumberPatient)
    {
        $url = Url::historyEncounterUrl($ihsNumberPatient);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Encounter::history($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function createCondition($encounter,$patient,$code,$name)
    {
        $url = Url::createConditionUrl();
        $formData = jsonData\Condition::formCreateData($encounter,$patient,$code,$name);
        $http = HttpResponse::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Condition::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateCondition($ihsNumber,$encounter,$patient,$code,$name)
    {
        $url = Url::updateConditionUrl($ihsNumber);
        $formData = jsonData\Condition::formUpdateData($ihsNumber,$encounter,$patient,$code,$name);
        $http = HttpResponse::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Condition::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyCondition($ihsNumberPatient)
    {
        $url = Url::historyConditionUrl($ihsNumberPatient);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Condition::history($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function createObservation($encounter,$patient,$practitioner,$code,$name,$value,$unit)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateData($encounter,$patient,$practitioner,$code,$name,$value,$unit);
        $http = HttpResponse::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Observation::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateObservation($ihsNumber,$observation,$encounter,$patient,$practitioner,$code,$name,$value,$unit)
    {
        $url = Url::updateObservationUrl($ihsNumber);
        $formData = jsonData\Observation::formUpdateData($ihsNumber,$observation,$encounter,$patient,$practitioner,$code,$name,$value,$unit);
        $http = HttpResponse::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Observation::convert($response);
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyObservation($ihsNumberPatient)
    {
        $url = Url::historyObservationUrl($ihsNumberPatient);
        $http = HttpResponse::get($url);
        if ($http['status']) {
            $response = $http['response'];
            $data = jsonResponse\Observation::history($response);
            return [
                'status' => true,
                'data' => $data
            ];
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
                ////////////////////////////////////////////////////////////////////////
                $pool->as('encounter')->asForm()->withToken($token)->get($urlEncounter);
                $pool->as('condition')->asForm()->withToken($token)->get($urlCondition);
                $pool->as('observation')->asForm()->withToken($token)->get($urlObservation);
            });
            $data['encounter'] = [];
            $data['condition'] = [];
            $data['observation'] = [];
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
            return $data;
        }
        return jsonResponse\Error::getToken($getToken);
    }
}
