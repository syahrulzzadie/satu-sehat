<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Procedure
{
    public static function formCreateData($encounter, $procedureCode, $procedureName)
    {
        return [
            "resourceType"=> "Procedure",
            "status"=> "completed",
            "category"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> "103693007",
                        "display"=> "Diagnostic procedure"
                    ]
                ],
                "text"=> "Diagnostic procedure"
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-9-cm",
                        "code"=> $procedureCode,
                        "display"=> $procedureName
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Tindakan pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "performedPeriod"=> [
                "start"=> DateTimeFormat::parse($encounter->period_start),
                "end"=> DateTimeFormat::parse($encounter->period_start)
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                        "display"=> $encounter->practitioner->name
                    ]
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $encounter, $procedureCode, $procedureName)
    {
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "Procedure",
            "status"=> "completed",
            "category"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> "103693007",
                        "display"=> "Diagnostic procedure"
                    ]
                ],
                "text"=> "Diagnostic procedure"
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-9-cm",
                        "code"=> $procedureCode,
                        "display"=> $procedureName
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Tindakan pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "performedPeriod"=> [
                "start"=> DateTimeFormat::parse($encounter->period_start),
                "end"=> DateTimeFormat::parse($encounter->period_start)
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                        "display"=> $encounter->practitioner->name
                    ]
                ]
            ]
        ];
    }
}