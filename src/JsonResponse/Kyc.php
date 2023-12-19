<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Kyc
{
    public static function convertGenerateUrl($response) : array
    {
        $data = json_decode($response,true);
        $cekMetadata = isset($data['metadata']);
        if ($cekMetadata) {
            $code = $data['metadata']['code'];
            if (intval($code) == 200) {
                return [
                    'status' => true,
                    'data' => $data['data']
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Error get generate url'
        ];
    }

    public static function convertChallengeCode($response) : array
    {
        $data = json_decode($response,true);
        $cekMetadata = isset($data['metadata']);
        if ($cekMetadata) {
            $code = $data['metadata']['code'];
            if (intval($code) == 200) {
                return [
                    'status' => true,
                    'data' => $data['data']
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Error get challenge code'
        ];
    }
}