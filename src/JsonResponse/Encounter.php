<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;
use Exception;
use TypeError;

set_error_handler(function ($severity, $message, $previous) {
    throw new Exception($message, 0, $previous);
});

class Encounter
{
    public static function convert($response)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'];
        if ($resType == 'Encounter') {
            try {
                return [
                    'status' => true,
                    'data' => [
                        'status' => $data['status'],
                        'ihs_number' => $data['id'],
                        'no_rawat' => $data['identifier'][0]['value'] ?? '',
                        'ihs_number_patient' => StrHelper::getIhsNumber($data['subject']['reference']),
                        'name_patient' => $data['subject']['display'] ?? '',
                        'ihs_number_location' => StrHelper::getIhsNumber($data['location'][0]['location']['reference']),
                        'name_location' => $data['location'][0]['location']['display'] ?? '',
                        'ihs_number_practitioner' => StrHelper::getIhsNumber($data['participant'][0]['individual']['reference']),
                        'name_practitioner' => $data['participant'][0]['individual']['display'] ?? '',
                        'ihs_number_organization' => StrHelper::getIhsNumber($data['serviceProvider']['reference']),
                        'name_organization' => $data['serviceProvider']['display'] ?? '',
                        'period_start' => $data['period']['start'] ?? '',
                        'period_end' => $data['period']['end'] ?? ''
                    ]
                ];
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            } catch (TypeError $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    private static function getDiagnosis($res)
    {
        $data = [];
        $diagnosis = $res['diagnosis'] ?? [];
        foreach ($diagnosis as $item) {
            $dt['ihs_number_condition'] = StrHelper::getIhsNumber($item['condition']['reference']);
            $dt['condition_name'] = $item['condition']['display'];
            $dt['rank'] = $item['rank'] ?? '1';
            $dt['coding_code'] = $item['use']['coding'][0]['code'];
            $dt['coding_name'] = $item['use']['coding'][0]['display'];
            $data[] = $dt;
        }
        return $data;
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
                if ($resType == 'Encounter') {
                    try {
                        $dt['consent'] = 'OPTIN';
                        $dt['status'] = $res['status'];
                        $dt['ihs_number'] = $res['id'];
                        $dt['no_rawat'] = $res['identifier'][0]['value'] ?? '';
                        $dt['ihs_number_patient'] = StrHelper::getIhsNumber($res['subject']['reference']);
                        $dt['name_patient'] = $res['subject']['display'] ?? '';
                        $dt['ihs_number_location'] = StrHelper::getIhsNumber($res['location'][0]['location']['reference']);
                        $dt['name_location'] = $res['location'][0]['location']['display'] ?? '';
                        $dt['ihs_number_practitioner'] = StrHelper::getIhsNumber($res['participant'][0]['individual']['reference']);
                        $dt['name_practitioner'] = $res['participant'][0]['individual']['display'] ?? '';
                        $dt['ihs_number_organization'] = StrHelper::getIhsNumber($res['serviceProvider']['reference']);
                        $dt['name_organization'] = $res['serviceProvider']['display'] ?? '';
                        $dt['period_start'] = $res['period']['start'] ?? '';
                        $dt['period_end'] = $res['period']['end'] ?? '';
                        $dt['diagnosis'] = self::getDiagnosis($res);
                    } catch (Exception $e) {
                        $dt['consent'] = 'OPTOUT';
                        $dt['message'] = $e->getMessage();
                    } catch (TypeError $e) {
                        $dt['consent'] = 'OPTOUT';
                        $dt['message'] = $e->getMessage();
                    }
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