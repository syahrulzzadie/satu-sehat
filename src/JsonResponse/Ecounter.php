<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Ecounter
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        return [
            'ihs_number' => $data['id']
        ];
    }

    private static function getDiagnosis($res)
    {
        $data = [];
        $diagnosis = $res['diagnosis'] ?? [];
        foreach ($diagnosis as $item) {
            $dt['ihs_number_condition'] = StrHelper::getIhsNumber($item['condition']['reference']);
            $dt['condition_name'] = $item['condition']['display'];
            $dt['rank'] = $item['rank'];
            $dt['coding_code'] = $item['use']['coding'][0]['code'];
            $dt['coding_name'] = $item['use']['coding'][0]['display'];
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
            $dt['ihs_number'] = $res['id'];
            $dt['ihs_number_location'] = StrHelper::getIhsNumber($res['location'][0]['location']['reference']);
            $dt['location_name'] = $res['location'][0]['location']['display'];
            $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['participant'][0]['individual']['reference']);
            $dt['practitioner_name'] = $res['participant'][0]['individual']['display'];
            $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['display']['reference']);
            $dt['patient_name'] = $res['subject']['display']['display'];
            $dt['diagnosis'] = self::getDiagnosis($res);
            $history[] = $dt;
        }
        return $history;
    }
}