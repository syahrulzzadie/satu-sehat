<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class DiagnosticReport
{
    /**
     * DiagnosticReport hasil laboratorium.
     * basedOn ServiceRequest, specimen Specimen, result Observation (category laboratory).
     */
    public static function formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null)
    {
        $organizationId = Enviroment::organizationId();
        $formData = self::baseData('lab',$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime);
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/v2-0074",
                        "code"=> "LAB",
                        "display"=> "Laboratory"
                    ]
                ]
            ]
        ];
        if (!empty($specimenIhs)) {
            $formData["specimen"] = [
                [
                    "reference"=> "Specimen/".$specimenIhs
                ]
            ];
        }
        $formData["performer"][] = [
            "reference"=> "Organization/".$organizationId
        ];
        return $formData;
    }

    /**
     * DiagnosticReport hasil radiologi (expertise).
     * basedOn ServiceRequest, result Observation (category imaging), imagingStudy opsional.
     */
    public static function formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null,$imagingStudyIhs = null)
    {
        $organizationId = Enviroment::organizationId();
        $formData = self::baseData('rad',$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime);
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/v2-0074",
                        "code"=> "RAD",
                        "display"=> "Radiology"
                    ]
                ]
            ]
        ];
        if (!empty($imagingStudyIhs)) {
            $formData["imagingStudy"] = [
                [
                    "reference"=> "ImagingStudy/".$imagingStudyIhs
                ]
            ];
        }
        $formData["performer"][] = [
            "reference"=> "Organization/".$organizationId
        ];
        return $formData;
    }

    public static function formUpdateDataLab($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime);
        return ["id"=> $ihsNumber] + $formData;
    }

    public static function formUpdateDataRadiologi($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null,$imagingStudyIhs = null)
    {
        $formData = self::formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime,$imagingStudyIhs);
        return ["id"=> $ihsNumber] + $formData;
    }

    private static function baseData($type,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime)
    {
        $organizationId = Enviroment::organizationId();
        $formData = [
            "resourceType"=> "DiagnosticReport",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/diagnostic/".$organizationId."/".$type,
                    "use"=> "official",
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
                ]
            ],
            "basedOn"=> [
                [
                    "reference"=> "ServiceRequest/".$serviceRequestIhs
                ]
            ],
            "conclusion"=> $conclusion
        ];
        if (!empty($observationIhs)) {
            $formData["result"] = [
                [
                    "reference"=> "Observation/".$observationIhs
                ]
            ];
        }
        return $formData;
    }
}
