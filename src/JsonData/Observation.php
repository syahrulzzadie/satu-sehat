<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Observation
{
    public static function formCreateData($encounter,$patient,$practitioner,$code,$name,$value,$unit)
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
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number
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
                "code"=> $unit
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$observation,$encounter,$patient,$practitioner,$code,$name,$value,$unit)
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
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "effectiveDateTime"=> $observation->effective,
            "issued"=> $observation->issued,
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $value,
                "unit"=> $unit,
                "code"=> $unit
            ]
        ];
    }
}