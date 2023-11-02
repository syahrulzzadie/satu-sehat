<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Condition
{
    public static function formCreateData($encounter,$patient,$diagnosis)
    {
        $dataDiagnosis = [];
        foreach ($diagnosis as $code => $name) {
            $dataDiagnosis[] = [
                "system"=> "http://hl7.org/fhir/sid/icd-10",
                "code"=> $code,
                "display"=> $name
            ];
        }
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
                "coding"=> $dataDiagnosis
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

    public static function formUpdateData($ihsNumber,$encounter,$patient,$diagnosis)
    {
        $dataDiagnosis = [];
        foreach ($diagnosis as $code => $name) {
            $dataDiagnosis[] = [
                "system"=> "http://hl7.org/fhir/sid/icd-10",
                "code"=> $code,
                "display"=> $name
            ];
        }
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
                "coding"=> $dataDiagnosis
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