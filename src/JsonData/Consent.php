<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Consent
{
    public static function formData($ihsNumber,$nm_petugas,$action)
    {
        return [
            'patient_id' => $ihsNumber,
            'action' => $action,
            'agent' => $nm_petugas
        ];
    }
}