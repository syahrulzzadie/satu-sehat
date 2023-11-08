<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Organization
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        $resType = $data['resourceType'];
        if ($resType == 'Organization') {
            return [
                'status' => true,
                'ihs_number' => $data['id'],
                'name' => $data['name']
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}