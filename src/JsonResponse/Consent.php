<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Consent
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        $resType = $data['resourceType'];
        if ($resType == 'Consent') {
            $code = $data['policyRule']['coding'][0]['code'];
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'code' => $code
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}