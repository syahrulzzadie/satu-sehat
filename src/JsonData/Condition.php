<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Condition
{
    public static function formCreateData($encounter,$patient,$code,$name)
    {
        return [
            "resourceType"=> "Condition",
            "clinicalStatus"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code"=> "active",
                        "display"=> "Active"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code"=> "encounter-diagnosis",
                            "display"=> "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-10",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$patient,$code,$name)
    {
        return [
            "resourceType"=> "Condition",
            "id"=> $ihsNumber,
            "clinicalStatus"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code"=> "active",
                        "display"=> "Active"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code"=> "encounter-diagnosis",
                            "display"=> "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-10",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ]
        ];
    }
}