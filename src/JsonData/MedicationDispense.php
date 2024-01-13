<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class MedicationDispense
{
    public static function formCreateData($encounter, $practitioner, $noRawat, $medicationRequest)
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
            "authorizingPrescription"=> [
                [
                    "reference"=> "MedicationRequest/".$medicationRequest->ihs_number
                ]
            ],
            "medicationReference"=> [
                "reference"=> "Medication/".$medicationRequest->medication->ihs_number,
                "display"=> $medicationRequest->medication->name
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

    public static function formUpdateData($ihsNumber, $encounter, $practitioner, $noRawat, $medicationRequest)
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
            "authorizingPrescription"=> [
                [
                    "reference"=> "MedicationRequest/".$medicationRequest->ihs_number
                ]
            ],
            "medicationReference"=> [
                "reference"=> "Medication/".$medicationRequest->medication->ihs_number,
                "display"=> $medicationRequest->medication->name
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