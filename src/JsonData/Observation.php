<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Observation
{
    public static function formCreateData($encounter,$code,$name,$value,$unit)
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

    public static function bundleFormCreateData($ihsNumberEncounter,$date,$time,$patient,$practitioner,$observation)
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
                        "code"=> $observation['code'],
                        "display"=> $observation['name']
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$ihsNumberEncounter
            ],
            "effectiveDateTime"=> DateTimeFormat::dateParseDateAndTime($date,$time),
            "issued"=> DateTimeFormat::parseDateAndTime($date,$time),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $observation['value'],
                "unit"=> $observation['unit'],
                "code"=> $observation['code']
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$code,$name,$value,$unit)
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
                "code"=> $unit
            ]
        ];
    }
}