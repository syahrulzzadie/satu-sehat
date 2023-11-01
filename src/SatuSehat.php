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

    public static function createLocation($name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createLocationUrl();
            $formData = jsonData\Location::formCreateData($name);
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

    public static function updateLocation($ihsNumber, $name)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateLocationUrl($ihsNumber);
            $formData = jsonData\Location::formUpdateData($ihsNumber,$name);
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

    public static function createEcounter($status,$organization,$patient,$practitioner,$location)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::createEcounterUrl();
            $formData = jsonData\Ecounter::formCreateData($status,$organization,$patient,$practitioner,$location);
            $response = Http::withToken($getToken['token'])
                ->post($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Ecounter::convert($response);
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

    public static function updateEcounter($ihsNumber,$status,$createdAt,$organization,$patient,$practitioner,$location)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = Url::updateEcounterUrl($ihsNumber);
            $formData = jsonData\Ecounter::formUpdateData($ihsNumber,$status,$createdAt,$organization,$patient,$practitioner,$location);
            $response = Http::withToken($getToken['token'])
                ->put($url, $formData);
            if ($response->successful()) {
                if ($response->status() == 201) {
                    $data = jsonResponse\Ecounter::convert($response);
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
}
