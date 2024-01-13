<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class MedicationDispense
{
    public static function convert($response)
    {
        $data = json_decode($response, true);
        $resType = $data['resourceType'];
        if ($resType == 'MedicationDispense') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'ihs_number_medication' => StrHelper::getIhsNumber($data['medicationReference']['reference']),
                    'name_medication' => $data['medicationReference']['display'] ?? '',
                    'ihs_number_practitioner' => StrHelper::getIhsNumber($data['performer'][0]['actor']['reference']),
                    'name_practitioner' => $data['performer'][0]['actor']['display'] ?? '',
                    'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                    'name_patient' => $data['subject']['display'] ?? '',
                    'ihs_number_encounter' => StrHelper::getIhsNumber($data['context']['reference']),
                    'name_encounter' => $res['context']['display'] ?? '',
                    'ihs_number_location' => StrHelper::getIhsNumber($data['location']['reference']),
                    'name_location' => $res['location']['display'] ?? '',
                    'ihs_number_medication_request' => StrHelper::getIhsNumber($data['authorizingPrescription'][0]['reference']),
                    'name_medication_request' => $res['authorizingPrescription'][0]['display'] ?? ''
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
                if ($resType == 'MedicationDispense') {
                    $dt['consent'] = 'OPTIN';
                    $dt['ihs_number'] = $res['id'];
                    $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                    $dt['name_patient'] = $res['subject']['display'] ?? '';
                    $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['performer'][0]['actor']['reference']);
                    $dt['name_practitioner'] = $res['performer'][0]['actor']['display'] ?? '';
                    $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($res['context']['reference']);
                    $dt['name_encounter'] = $res['context']['display'] ?? '';
                    $dt['ihs_number_medication'] = StrHelper::getIhsNumber($res['medicationReference']['reference']);
                    $dt['name_medication'] = $res['medicationReference']['display'] ?? '';
                    $dt['ihs_number_location'] = StrHelper::getIhsNumber($res['location']['reference']);
                    $dt['name_location'] = $res['location']['display'] ?? '';
                    $dt['ihs_number_medication_request'] = StrHelper::getIhsNumber($res['authorizingPrescription'][0]['reference']);
                    $dt['name_medication_request'] = $res['authorizingPrescription'][0]['display'] ?? '';
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