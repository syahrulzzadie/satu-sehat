<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Ssrme
{
    public static function convert($response)
    {
        $data = json_decode($response, true);
        // SSRME v2 menandai sukses dgn "success": true; versi lama memakai "error": false
        $isSuccess = (isset($data['error']) && $data['error'] === false)
            || (isset($data['success']) && $data['success'] === true);
        if ($isSuccess) {
            $result = $data['data'] ?? [];
            $result['request_id'] = $data['request_id'] ?? null;
            return [
                'status' => true,
                'message' => $data['message'] ?? 'OK',
                'data' => $result
            ];
        }
        // Contoh gagal: {"code":403,"message":"consent required","data":{"code":"CONSENT_REQUIRED"}},
        // {"code":400,"data":"wrong organization"}, {"code":400,"message":"pasien dengan ID ... tidak ditemukan"}
        $detail = $data['data'] ?? [];
        $message = $data['message']
            ?? (is_string($detail) ? $detail : null)
            ?? $data['fault']['faultstring']
            ?? $data['fault']['detail']['errorcode']
            ?? 'Permintaan SSRME gagal.';
        return [
            'status' => false,
            'message' => $message,
            'code' => is_array($detail) ? ($detail['code'] ?? null) : null,
            'http_code' => $data['code'] ?? $data['status'] ?? null,
            'data' => is_array($detail) ? $detail : []
        ];
    }
}
