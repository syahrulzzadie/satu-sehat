<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Procedure
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        $resType = $data['resourceType'];
        if ($resType == 'Procedure') {
            return [
                'status' => true,
                'ihs_number' => $data['id'],
                'period_start' => $data['performedPeriod']['start'],
                'period_end' => $data['performedPeriod']['end'],
                'code' => $data['code']['coding'][0]['code'],
                'name' => $data['code']['coding'][0]['display'],
                'text' => $data['note'][0]['text'],
                'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                'name_patient' => $data['subject']['display'] ?? '',
                'ihs_number_encounter' => StrHelper::getIhsNumber($data['encounter']['reference']),
                'name_encounter' => $data['encounter']['display'] ?? '',
                'ihs_practitioner' => StrHelper::getIhsNumber($data['performer'][0]['actor']['reference']),
                'name_practitioner' => $data['performer'][0]['actor']['display'] ?? ''
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    public static function history($response)
    {
        $history = [];
        $data = json_decode($response->body(),true);
        $entry = $data['entry'];
        foreach ($entry as $item) {
            $res = $item['resource'];
            $resType = $res['resourceType'];
            if ($resType == 'Composition') {
                $dt['consent'] = 'OPTIN';
                $dt['ihs_number'] = $res['id'];
                $dt['period_start'] = $res['performedPeriod']['start'];
                $dt['period_end'] = $res['performedPeriod']['end'];
                $dt['code'] = $res['code']['coding'][0]['code'];
                $dt['name'] = $res['code']['coding'][0]['display'];
                $dt['text'] = $res['note'][0]['text'];
                $dt['ihs_number_patient'] = StrHelper::getIhsNumber($data['subject']['reference']);
                $dt['name_patient'] = $res['subject']['display'] ?? '';
                $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($data['encounter']['reference']);
                $dt['name_encounter'] = $res['encounter']['display'] ?? '';
                $dt['ihs_practitioner'] = StrHelper::getIhsNumber($data['performer'][0]['actor']['reference']);
                $dt['name_practitioner'] = $res['performer'][0]['actor']['display'] ?? '';
            } else {
                $dt['consent'] = 'OPTOUT';
                $dt['message'] = 'The operation did not return any information due to consent or privacy rules.';
            }
            $history[] = $dt;
        }
        return $history;
    }
}