<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Organization
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        $resType = $data['resourceType'];
        if ($resType == 'Organization') {
            return [
                'status' => true,
                'data' => [
                    'ihs_number' => $data['id'],
                    'name' => $data['name']
                ]
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }

    public static function show($response) : array
    {
        if (!Error::searchIsEmpty($response)) {
            $data = json_decode($response->body(),true);
            $entry = $data['entry'] ?? false;
            if ($entry) {
                $resource = $entry[0]['resource'];
                $resType = $resource['resourceType'];
                if ($resType == 'Organization') {
                    return [
                        'status' => true,
                        'data' => [
                            'ihs_number' => $resource['id'],
                            'name' => $resource['name'],
                            'kode' => $resource['identifier'][0]['value']
                        ]
                    ];
                }
                return Error::checkOperationOutcome($resType,$data);
            }
            return [
                'status' => false,
                'message' => $response->body()
            ];
        }
        return [
            'status' => false,
            'message' => 'Data tidak ditemukan!'
        ];
    }
}