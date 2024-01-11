<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Medication
{
    public static function convert($response)
    {
        $data = json_decode($response, true);
        $resType = $data['resourceType'];
        if ($resType == 'Medication') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'code' => $data['code']['coding'][0]['code'],
                    'name' => $data['code']['coding'][0]['display']
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}