<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Consent
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        $code = $data['policyRule']['coding'][0]['code'];
        $status = $code == 'OPTIN' ? 'setuju' : 'tidak_setuju';
        return [
            'ihs_number' => $data['id'],
            'status' => $status
        ];
    }
}