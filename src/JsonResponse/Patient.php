<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Patient
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        return [
            'nik' => $data['entry'][0]['resource']['identifier'][1]['value'],
            'ihs_number' => $data['entry'][0]['resource']['id'],
            'nama' => $data['entry'][0]['resource']['name'][0]['text']
        ];
    }
}
