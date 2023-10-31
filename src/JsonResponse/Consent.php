<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Consent
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        $status = $data['policyRule']['coding'][0]['code'];
        return [
            'ihs_number' => $data['id'],
            'status' => $status
        ];
    }
}