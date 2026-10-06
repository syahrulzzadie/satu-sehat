<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class DiagnosticReport
{
    private static function toData($res)
    {
        return [
            'ihs_number' => $res['id'],
            'no_permintaan' => $res['identifier'][0]['value'] ?? '',
            'category' => $res['category'][0]['coding'][0]['code'] ?? '',
            'code' => $res['code']['coding'][0]['code'] ?? '',
            'name' => $res['code']['coding'][0]['display'] ?? '',
            'conclusion' => $res['conclusion'] ?? '',
            'issued' => $res['issued'] ?? '',
            'ihs_number_patient' => StrHelper::getIhsNumber($res['subject']['reference'] ?? '/'),
            'name_patient' => $res['subject']['display'] ?? '',
            'ihs_number_encounter' => StrHelper::getIhsNumber($res['encounter']['reference'] ?? '/'),
            'ihs_number_practitioner' => StrHelper::getIhsNumber($res['performer'][0]['reference'] ?? '/'),
            'name_practitioner' => $res['performer'][0]['display'] ?? '',
            'ihs_number_service_request' => StrHelper::getIhsNumber($res['basedOn'][0]['reference'] ?? '/'),
            'ihs_number_observation' => StrHelper::getIhsNumber($res['result'][0]['reference'] ?? '/'),
            'ihs_number_specimen' => StrHelper::getIhsNumber($res['specimen'][0]['reference'] ?? '/'),
            'ihs_number_imaging_study' => StrHelper::getIhsNumber($res['imagingStudy'][0]['reference'] ?? '/')
        ];
    }

    public static function convert($response)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'] ?? '';
        if ($resType == 'DiagnosticReport') {
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
                if (($res['resourceType'] ?? '') == 'DiagnosticReport') {
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
