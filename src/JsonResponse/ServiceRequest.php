<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class ServiceRequest
{
    public static function convert($response)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'];
        if ($resType == 'ServiceRequest') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'no_rawat' => $data['identifier'][0]['value'] ?? '',
                    'code_text' => $data['code']['coding'][0]['text'] ?? '',
                    'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                    'name_patient' => $data['subject']['display'] ?? '',
                    'ihs_number_encounter' => StrHelper::getIhsNumber($data['encounter']['reference']),
                    'name_encounter' => $data['encounter']['display'] ?? '',
                    'ihs_number_practitioner' => StrHelper::getIhsNumber($data['requester']['reference']),
                    'name_practitioner' => $data['requester']['display'] ?? '',
                    'ihs_number_performer' => StrHelper::getIhsNumber($data['performer'][0]['reference']),
                    'name_performer' => $data['performer'][0]['display'] ?? '',
                    'ihs_number_location' => StrHelper::getIhsNumber($data['locationReference'][0]['reference']),
                    'name_location' => $data['locationReference'][0]['display'] ?? ''
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
                if ($resType == 'ServiceRequest') {
                    $dt['consent'] = 'OPTIN';
                    $dt['ihs_number'] = $res['id'];
                    $dt['no_rawat'] = $res['identifier'][0]['value'] ?? '';
                    $dt['code_text'] = $data['code']['coding'][0]['text'] ?? '';
                    $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                    $dt['name_patient'] = $res['subject']['display'] ?? '';
                    $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($res['encounter']['reference']);
                    $dt['name_encounter'] = $res['encounter']['display'] ?? '';
                    $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['requester']['reference']);
                    $dt['name_practitioner'] = $res['requester']['display'] ?? '';
                    $dt['ihs_number_performer'] = StrHelper::getIhsNumber($res['performer'][0]['reference']);
                    $dt['name_performer'] = $res['performer'][0]['display'] ?? '';
                    $dt['ihs_number_location'] = StrHelper::getIhsNumber($res['locationReference'][0]['reference']);
                    $dt['name_location'] = $res['locationReference'][0]['display'] ?? '';
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