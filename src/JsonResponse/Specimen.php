<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Specimen
{
    private static function toData($res)
    {
        return [
            'ihs_number' => $res['id'],
            'no_specimen' => $res['identifier'][0]['value'] ?? '',
            'code' => $res['type']['coding'][0]['code'] ?? '',
            'name' => $res['type']['coding'][0]['display'] ?? '',
            'collected_at' => $res['collection']['collectedDateTime'] ?? '',
            'ihs_number_patient' => StrHelper::getIhsNumber($res['subject']['reference'] ?? '/'),
            'name_patient' => $res['subject']['display'] ?? '',
            'ihs_number_service_request' => StrHelper::getIhsNumber($res['request'][0]['reference'] ?? '/')
        ];
    }

    public static function convert($response)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'] ?? '';
        if ($resType == 'Specimen') {
            return [
                'status' => true,
                'data' => self::toData($data)
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    public static function history($response)
    {
        $history = [];
        $data = json_decode($response,true);
        $entry = $data['entry'] ?? false;
        if ($entry) {
            foreach ($entry as $item) {
                $res = $item['resource'];
                if (($res['resourceType'] ?? '') == 'Specimen') {
                    $dt = ['consent' => 'OPTIN'] + self::toData($res);
                } else {
                    $dt = [
                        'consent' => 'OPTOUT',
                        'message' => 'The operation did not return any information due to consent or privacy rules.'
                    ];
                }
                $history[] = $dt;
            }
        }
        return $history;
    }
}
