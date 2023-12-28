<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Observation
{
    public static function formCreateData($encounter,$name,$value)
    {
        $ttv = StrHelper::getTtv($name,$value);
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
                        "code"=> $ttv['code_ttv'],
                        "display"=> $ttv['name_ttv']
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
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($encounter->period_start),
            "issued"=> DateTimeFormat::parse($encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['unit'],
                "code"=> $ttv['code']
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$name,$value)
    {
        $ttv = StrHelper::getTtv($name,$value);
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
                        "code"=> $ttv['code_ttv'],
                        "display"=> $ttv['name_ttv']
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
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($encounter->period_start),
            "issued"=> DateTimeFormat::parse($encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['value'],
                "code"=> $ttv['code']
            ]
        ];
    }
}