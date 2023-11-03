<?php

namespace syahrulzzadie\SatuSehat;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class SatuSehat
{
    public static function getPatientByNik($nik)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::patientUrl($nik);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Patient::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function getPractitionerByNik($nik)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::practitionerUrl($nik);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Practitioner::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function createOrganization($name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createOrganizationUrl();
            $formData = jsonData\Organization::formCreateData($name);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Organization::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateOrganization($ihsNumber, $name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateOrganizationUrl($ihsNumber);
            $formData = jsonData\Organization::formUpdateData($ihsNumber,$name);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Organization::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function createLocation($organization,$name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createLocationUrl();
            $formData = jsonData\Location::formCreateData($organization,$name);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Location::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateLocation($ihsNumber,$organization,$name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateLocationUrl($ihsNumber);
            $formData = jsonData\Location::formUpdateData($ihsNumber,$organization,$name);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Location::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function getConsent($ihsNumber)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::getConsentPatientUrl($ihsNumber);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Consent::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateConsent($ihsNumber,$nm_petugas,$status)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateConsentPatientUrl();
            $formData = jsonData\Consent::formData($ihsNumber,$nm_petugas,$status);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Consent::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function createEncounter($organization,$patient,$practitioner,$location)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createEncounterUrl();
            $formData = jsonData\Encounter::formCreateData($organization,$patient,$practitioner,$location);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Encounter::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateEncounter($ihsNumber,$status,$createdAt,$organization,$patient,$practitioner,$location)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateEncounterUrl($ihsNumber);
            $formData = jsonData\Encounter::formUpdateData($ihsNumber,$status,$createdAt,$organization,$patient,$practitioner,$location);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Encounter::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function historyEncounter($ihsNumberPatient)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::historyEncounterUrl($ihsNumberPatient);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Encounter::history($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function createCondition($encounter,$patient,$code,$name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createConditionUrl();
            $formData = jsonData\Condition::formCreateData($encounter,$patient,$code,$name);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Condition::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateCondition($ihsNumber,$encounter,$patient,$code,$name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateConditionUrl($ihsNumber);
            $formData = jsonData\Condition::formUpdateData($ihsNumber,$encounter,$patient,$code,$name);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Condition::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function historyCondition($ihsNumberPatient)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::historyConditionUrl($ihsNumberPatient);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Condition::history($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function createObservation($encounter,$patient,$practitioner,$code,$name,$value,$unit)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createObservationUrl();
            $formData = jsonData\Observation::formCreateData($encounter,$patient,$practitioner,$code,$name,$value,$unit);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Observation::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function updateObservation($ihsNumber,$observation,$encounter,$patient,$practitioner,$code,$name,$value,$unit)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateObservationUrl($ihsNumber);
            $formData = jsonData\Observation::formUpdateData($ihsNumber,$observation,$encounter,$patient,$practitioner,$code,$name,$value,$unit);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Observation::convert($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function historyObservation($ihsNumberPatient)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::historyObservationUrl($ihsNumberPatient);
            $response = Http::asForm()
                ->withToken($getToken['token'])
                ->get($url);
            if ($response->successful()) {
                if ($response->status() == 200) {
                    $data = jsonResponse\Observation::history($response);
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            return jsonResponse\Error::response($response);
        }
        return jsonResponse\Error::getToken($getToken);
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
            $data = [
                'encounter' => [],
                'condition' => [],
                'observation' => []
            ];
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
            return [
                'status' => true,
                'data' => $data
            ];
        }
        return jsonResponse\Error::getToken($getToken);
    }
}
