<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Practitioner
{
    public static function convert($response) : array
    {
        $data = json_decode($response->body(),true);
        $resource = $data['entry'][0]['resource'];
        return [
            'ihs_number' => $resource['id'],
            'nik' => $resource['identifier'][1]['value'],
            'name' => $resource['name'][0]['text']
        ];
    }
}
