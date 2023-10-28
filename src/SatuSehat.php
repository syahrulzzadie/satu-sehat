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
            return [
                'status' => false,
                'message' => 'Internal server error'
            ];
        } else {
            return [
                'status' => false,
                'message' => $getToken['message']
            ];
        }
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
            return [
                'status' => false,
                'message' => 'Internal server error'
            ];
        } else {
            return [
                'status' => false,
                'message' => $getToken['message']
            ];
        }
    }
}
