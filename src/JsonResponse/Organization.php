<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Organization
{
    public static function convert($response) : array
    {
        $data = json_decode($response,true);
        $resType = $data['resourceType'];
        if ($resType == 'Organization') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'name' => $data['name'],
                    'kode' => $data['identifier'][0]['value']
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    public static function show($response) : array
    {
        if (!Error::searchIsEmpty($response)) {
            $data = json_decode($response,true);
            $entry = $data['entry'] ?? false;
            if ($entry) {
                $dataEntry = [];
                foreach ($entry as $item) {
                    $resource = $item['resource'];
                    $resType = $resource['resourceType'];
                    if ($resType == 'Organization') {
                        $dataEntry[] = [
                            'ihs_number' => $resource['id'],
                            'name' => $resource['name'],
                            'kode' => $resource['identifier'][0]['value']
                        ];
                    }
                }
                return [
                    'status' => true,
                    'data' => $dataEntry
                ];
            }
            return [
                'status' => false,
                'message' => $response
            ];
        }
        return [
            'status' => false,
            'message' => 'Data tidak ditemukan!'
        ];
    }
}