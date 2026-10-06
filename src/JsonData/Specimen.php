<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Specimen
{
    public static function formCreateData($noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime = null)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Specimen",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/specimen/".$organizationId,
                    "value"=> $noSpecimen,
                    "assigner"=> [
                        "reference"=> "Organization/".$organizationId
                    ]
                ]
            ],
            "status"=> "available",
            "type"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> $specimenCode,
                        "display"=> $specimenName
                    ]
                ]
            ],
            "collection"=> [
                "collectedDateTime"=> DateTimeFormat::parse($collectedDateTime)
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "request"=> [
                [
                    "reference"=> "ServiceRequest/".$serviceRequestIhs
                ]
            ],
            "receivedTime"=> DateTimeFormat::parse($receivedDateTime ?? $collectedDateTime)
        ];
    }

    public static function formUpdateData($ihsNumber,$noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime = null)
    {
        $formData = self::formCreateData($noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime);
        return ["id"=> $ihsNumber] + $formData;
    }
}
