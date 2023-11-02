<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Condition
{
    public static function convert($response)
    {
        $data = json_decode($response->body(), true);
        return [
            'ihs_number' => $data['id']
        ];
    }

    private static function getDiagnosis($res)
    {
        $data = [];
        $diagnosis = $res['code']['coding'];
        foreach ($diagnosis as $item) {
            $dt['code'] = $item['code'];
            $dt['name'] = $item['display'];
            $data[] = $dt;
        }
        return $data;
    }

    public static function history($response)
    {
        $history = [];
        $data = json_decode($response->body(),true);
        $entry = $data['entry'];
        foreach ($entry as $item) {
            $res = $item['resource'];
            $resType = $res['resourceType'];
            if ($resType == 'Condition') {
                $dt['consent'] = 'OPTIN';
                $dt['ihs_number'] = $res['id'];
                $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($res['encounter']['reference']);
                $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                $dt['diagnosis'] = self::getDiagnosis($res);
            } else {
                $dt['consent'] = 'OPTOUT';
                $dt['message'] = 'The operation did not return any information due to consent or privacy rules.';
            }
            $history[] = $dt;
        }
        return $history;
    }
}