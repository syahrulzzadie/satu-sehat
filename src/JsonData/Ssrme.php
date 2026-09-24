<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Ssrme
{
    public static function formData($patient, $practitioner, $organization)
    {
        return [
            "patient_id" => $patient->ihs_number,
            "patient_name" => $patient->name,
            "practitioner_id" => $practitioner->ihs_number,
            "practitioner_name" => $practitioner->name,
            "organization_id" => $organization->ihs_number,
            "organization_name" => $organization->name
        ];
    }

    public static function formDataEmergency($patient, $practitioner, $organization, $emergencyReason)
    {
        $data = self::formData($patient, $practitioner, $organization);
        $data["type_medical_summary"] = "EMERGENCY";
        $data["emergency_reason"] = $emergencyReason;
        return $data;
    }
}
