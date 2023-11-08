<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Patient
{
    public static function convert($response): array
    {
        $data = json_decode($response->body(),true);
        $resource = $data['entry'][0]['resource'];
        $resType = $resource['resourceType'];
        if ($resType == 'Patient') {
            return [
                'status' => true,
                'nik' => $resource['identifier'][1]['value'],
                'ihs_number' => $resource['id'],
                'name' => $resource['name'][0]['text']
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}
