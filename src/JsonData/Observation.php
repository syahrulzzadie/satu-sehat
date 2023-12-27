<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Observation
{
    public static function formCreateData($encounter,$codeTtv,$nameTtv,$value,$unit,$code)
    {
        return [
            "resourceType"=> "Observation",
            "status"=> "final",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                            "code"=> "vital-signs",
                            "display"=> "Vital Signs"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> $codeTtv,
                        "display"=> $nameTtv
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "effectiveDateTime"=> DateTimeFormat::dateNow(),
            "issued"=> DateTimeFormat::now(),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $value,
                "unit"=> $unit,
                "code"=> $code
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$codeTtv,$nameTtv,$value,$unit,$code)
    {
        return [
            "resourceType"=> "Observation",
            "id"=> $ihsNumber,
            "status"=> "final",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                            "code"=> "vital-signs",
                            "display"=> "Vital Signs"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> $codeTtv,
                        "display"=> $nameTtv
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "effectiveDateTime"=> $encounter->observation->effective,
            "issued"=> $encounter->observation->issued,
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $value,
                "unit"=> $unit,
                "code"=> $code
            ]
        ];
    }
}