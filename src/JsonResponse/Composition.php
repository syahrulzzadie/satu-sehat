<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Composition
{
    public static function getAllSection($dataSection)
    {
        if (count($dataSection) == 0) {
            return '';
        }
        $allText = "";
        foreach ($dataSection as $section) {
            $title = $section['text']['title'] ?? '';
            $text = $section['text']['div'] ?? '';
            $allText .= $title." : ".strip_tags($text)."\n";
        }
        return $allText;
    }
    public static function convert($response)
    {
        $data = json_decode($response, true);
        $resType = $data['resourceType'];
        if ($resType == 'Composition') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'composition_text' => self::getAllSection($data['section']),
                    'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                    'name_patient' => $data['subject']['display'] ?? '',
                    'ihs_number_encounter' => StrHelper::getIhsNumber($data['encounter']['reference']),
                    'name_encounter' => $data['encounter']['display'] ?? '',
                    'ihs_number_practitioner' => StrHelper::getIhsNumber($data['author'][0]['reference']),
                    'name_practitioner' => $data['author'][0]['display'] ?? ''
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
                if ($resType == 'Composition') {
                    $dt['consent'] = 'OPTIN';
                    $dt['ihs_number'] = $res['id'];
                    $dt['composition_text'] = self::getAllSection($res['section']);
                    $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                    $dt['name_patient'] = $res['subject']['display'] ?? '';
                    $dt['ihs_number_encounter'] = StrHelper::getIhsNumber($res['encounter']['reference']);
                    $dt['name_encounter'] = $res['encounter']['display'] ?? '';
                    $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['author'][0]['reference']);
                    $dt['name_practitioner'] = $res['author'][0]['display'] ?? '';
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