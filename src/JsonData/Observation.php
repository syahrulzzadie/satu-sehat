<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Observation
{
    public static function formCreateData($encounter,$practitioner,$name,$value,$effectiveDateTime = null)
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
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "issued"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['unit'],
                "code"=> $ttv['code']
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$practitioner,$name,$value,$effectiveDateTime = null)
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
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "issued"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['unit'],
                "code"=> $ttv['code']
            ]
        ];
    }

    /**
     * Observation hasil laboratorium (category laboratory) - dirujuk oleh DiagnosticReport lab.
     */
    public static function formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime);
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                        "code"=> "laboratory",
                        "display"=> "Laboratory"
                    ]
                ]
            ]
        ];
        if (!empty($specimenIhs)) {
            $formData["specimen"] = [
                "reference"=> "Specimen/".$specimenIhs
            ];
        }
        return $formData;
    }

    /**
     * Observation hasil bacaan radiologi (category imaging) - dirujuk oleh DiagnosticReport radiologi.
     */
    public static function formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime);
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                        "code"=> "imaging",
                        "display"=> "Imaging"
                    ]
                ]
            ]
        ];
        return $formData;
    }

    private static function baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Observation",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/observation/".$organizationId,
                    "value"=> $noPermintaan
                ]
            ],
            "status"=> "final",
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
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime),
            "issued"=> DateTimeFormat::parse($issuedDateTime ?? $effectiveDateTime),
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ],
                [
                    "reference"=> "Organization/".$organizationId
                ]
            ],
            "basedOn"=> [
                [
                    "reference"=> "ServiceRequest/".$serviceRequestIhs
                ]
            ],
            "valueString"=> $value
        ];
    }
}