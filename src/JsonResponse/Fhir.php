<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

/**
 * Converter response generik untuk resource FHIR apa pun.
 * Bentuk hasil sama dengan converter lain: ['status' => bool, 'data' => [...]] / ['status' => false, 'message' => ...]
 */
class Fhir
{
    /**
     * Response create/update/patch/get satu resource.
     * $resourceType null = terima resource apa pun selain OperationOutcome.
     */
    public static function convert($response, $resourceType = null)
    {
        $data = json_decode($response,true);
        if (!is_array($data)) {
            return [
                'status' => false,
                'message' => 'Response bukan JSON: '.substr((string) $response,0,300)
            ];
        }
        $resType = $data['resourceType'] ?? null;
        if ($resType && $resType != 'OperationOutcome' && ($resourceType === null || $resType == $resourceType)) {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'] ?? '',
                    'resource_type' => $resType,
                    'status' => $data['status'] ?? '',
                    'resource' => $data
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    /**
     * Response search (Bundle searchset). Resource hasil OPTOUT (OperationOutcome
     * di dalam entry) ditandai consent OPTOUT seperti converter history lain.
     */
    public static function search($response, $resourceType = null)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'] ?? null;
        if ($resType != 'Bundle') {
            return Error::checkOperationOutcome($resType,$data);
        }
        $entries = [];
        foreach ($data['entry'] ?? [] as $item) {
            $res = $item['resource'] ?? [];
            $type = $res['resourceType'] ?? null;
            if ($type && $type != 'OperationOutcome' && ($resourceType === null || $type == $resourceType)) {
                $entries[] = [
                    'consent' => 'OPTIN',
                    'ihs_number' => $res['id'] ?? '',
                    'resource_type' => $type,
                    'resource' => $res
                ];
            } else if ($type == 'OperationOutcome') {
                $entries[] = [
                    'consent' => 'OPTOUT',
                    'message' => $res['issue'][0]['details']['text'] ?? 'The operation did not return any information due to consent or privacy rules.'
                ];
            }
        }
        return [
            'status' => true,
            'data' => [
                'total' => $data['total'] ?? count($entries),
                'entry' => $entries,
                'link' => $data['link'] ?? []
            ]
        ];
    }

    /**
     * Response transaction Bundle: daftar resource yang tercipta + id-nya.
     */
    public static function bundle($response)
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'] ?? null;
        if ($resType != 'Bundle') {
            return Error::checkOperationOutcome($resType,$data);
        }
        $entries = [];
        foreach ($data['entry'] ?? [] as $item) {
            $res = $item['response'] ?? [];
            // location: https://.../fhir-r4/v1/Encounter/{id}/_history/{versi}
            $location = $res['location'] ?? '';
            preg_match('#([A-Za-z]+)/([^/]+)(?:/_history/[^/]+)?$#', $location, $match);
            $entries[] = [
                'status' => $res['status'] ?? '',
                'resource_type' => $res['resourceType'] ?? ($match[1] ?? ''),
                'ihs_number' => $res['resourceID'] ?? ($match[2] ?? ''),
                'location' => $location,
                'outcome' => $res['outcome'] ?? null
            ];
        }
        return [
            'status' => true,
            'data' => [
                'type' => $data['type'] ?? '',
                'entry' => $entries
            ]
        ];
    }

    /**
     * Response API non-FHIR (masterdata, KFA harga, dsb) dikembalikan apa adanya.
     */
    public static function raw($response)
    {
        $data = json_decode($response,true);
        if (!is_array($data)) {
            return [
                'status' => false,
                'message' => 'Response bukan JSON: '.substr((string) $response,0,300)
            ];
        }
        if (($data['resourceType'] ?? null) == 'OperationOutcome') {
            return Error::checkOperationOutcome('OperationOutcome',$data);
        }
        return [
            'status' => true,
            'data' => $data
        ];
    }
}
