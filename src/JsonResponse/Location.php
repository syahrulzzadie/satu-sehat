<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Location
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        $resType = $data['resourceType'];
        if ($resType == 'Location') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'name' => $data['name']
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}