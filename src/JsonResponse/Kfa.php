<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Kfa
{
    public static function convertByCode($response)
    {
        $data = json_decode($response,true);
        $result = $data['result'] ?? false;
        if ($result) {
            return [
                'status' => true,
                'data' => $result
            ];
        }
        return [
            'status' => false,
            'message' => 'Search not found!'
        ];
    }

    public static function convertByType($response)
    {
        $data = json_decode($response,true);
        $items = $data['items'] ?? false;
        if ($items) {
            $itemsData = $items['data'];
            return [
                'status' => true,
                'total' => $data['total'],
                'start' => $data['page'],
                'limit' => $data['size'],
                'data' => $itemsData
            ];
        }
        return [
            'status' => false,
            'message' => 'Search not found!'
        ];
    }
}