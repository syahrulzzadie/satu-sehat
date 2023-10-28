<?php

namespace syahrulzzadie\SatuSehat;

use Illuminate\Support\Facades\Http;
use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;

class SatuSehat
{
    public static function getPatientByNik($nik)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $url = _baseUrl_.'/Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik;
            $response = Http::asForm()
                ->withToken($getToken['data']['token'])
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
}
