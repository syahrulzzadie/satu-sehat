<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class MedicationRequest
{
    public static function convert($response)
    {
        $data = json_decode($response, true);
        $resType = $data['resourceType'];
        if ($resType == 'MedicationRequest') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'ihs_number_medication' => StrHelper::getIhsNumber($data['medicationReference']['reference']),
                    'name_medication' => $data['medicationReference']['display'] ?? '',
                    'ihs_number_practitioner' => StrHelper::getIhsNumber($data['requester']['reference']),
                    'name_practitioner' => $data['requester']['display'] ?? '',
                    'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                    'name_patient' => $data['subject']['display'] ?? '',
                    'ihs_number_encounter' => StrHelper::getIhsNumber($data['encounter']['reference']),
                    'name_encounter' => $res['encounter']['display'] ?? ''
                ]
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
                $resType = $res['resourceType'];
                if ($resType == 'MedicationRequest') {
                    $dt['consent'] = 'OPTIN';
                    $dt['ihs_number'] = $res['id'];
                    $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                    $dt['name_patient'] = $res['subject']['display'] ?? '';
                    $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['requester']['reference']);
                    $dt['name_practitioner'] = $res['requester']['display'] ?? '';
                    $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($res['encounter']['reference']);
                    $dt['name_encounter'] = $res['encounter']['display'] ?? '';
                    $dt['ihs_number_medication'] = StrHelper::getIhsNumber($res['medicationReference']['reference']);
                    $dt['name_medication'] = $res['medicationReference']['display'] ?? '';
                } else {
                    $dt['consent'] = 'OPTOUT';
                    $dt['message'] = 'The operation did not return any information due to consent or privacy rules.';
                }
                $history[] = $dt;
            }
        }
        return $history;
    }
}