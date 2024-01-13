<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class MedicationDispense
{
    public static function formCreateData($encounter, $practitioner, $noRawat, $medication)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "MedicationDispense",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "status"=> "completed",
            "medicationReference"=> [
                "reference"=> "Medication/".$medication->ihs_number,
                "display"=> $medication->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "context"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$practitioner->ihs_number,
                        "display"=> $practitioner->name
                    ]
                ]
            ],
            "location"=> [
                "reference"=> "Location/".$encounter->location->ihs_number,
                "display"=> $encounter->location->name
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $encounter, $practitioner, $medication, $noRawat)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "id" => $ihsNumber,
            "resourceType"=> "MedicationDispense",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "status"=> "completed",
            "medicationReference"=> [
                "reference"=> "Medication/".$medication->ihs_number,
                "display"=> $medication->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "context"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$practitioner->ihs_number,
                        "display"=> $practitioner->name
                    ]
                ]
            ],
            "location"=> [
                "reference"=> "Location/".$encounter->location->ihs_number,
                "display"=> $encounter->location->name
            ]
        ];
    }
}