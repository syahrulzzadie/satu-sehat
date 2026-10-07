<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Bundle
{
    /**
     * UUID v4 untuk fullUrl "urn:uuid:..." resource di dalam Bundle.
     */
    public static function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Reference ke resource lain di dalam Bundle yang sama.
     */
    public static function reference($uuid, $display = null)
    {
        $reference = ['reference' => 'urn:uuid:'.$uuid];
        if ($display !== null) {
            $reference['display'] = $display;
        }
        return $reference;
    }

    /**
     * $entries boleh berupa:
     * - resource array biasa (fullUrl dibuat otomatis, method POST)
     * - ['fullUrl' => 'urn:uuid:...', 'resource' => [...]] (request default POST {resourceType})
     * - entry lengkap dengan 'request' sendiri (mis. PUT Encounter/{id})
     */
    public static function transaction(array $entries)
    {
        $items = [];
        foreach ($entries as $entry) {
            if (!isset($entry['resource'])) {
                $entry = ['resource' => $entry];
            }
            $resourceType = $entry['resource']['resourceType'];
            $items[] = [
                'fullUrl' => $entry['fullUrl'] ?? 'urn:uuid:'.self::uuid(),
                'resource' => $entry['resource'],
                'request' => $entry['request'] ?? [
                    'method' => 'POST',
                    'url' => $resourceType
                ]
            ];
        }
        return [
            'resourceType' => 'Bundle',
            'type' => 'transaction',
            'entry' => $items
        ];
    }
}
