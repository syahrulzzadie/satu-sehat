<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Ssrme
{
    public static function convert($response)
    {
        $data = json_decode($response, true);
        if (isset($data['success']) && $data['success'] === true) {
            $result = $data['data'] ?? [];
            $result['request_id'] = $data['request_id'] ?? null;
            return [
                'status' => true,
                'message' => $data['message'] ?? 'OK',
                'data' => $result
            ];
        }
        $message = $data['message']
            ?? $data['fault']['faultstring']
            ?? $data['fault']['detail']['errorcode']
            ?? 'Permintaan SSRME gagal.';
        return [
            'status' => false,
            'message' => $message,
            'data' => $data['data'] ?? []
        ];
    }
}
