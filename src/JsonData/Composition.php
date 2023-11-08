<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Composition
{
    public static function formCreateData($encounter,$kodeDiet,$code,$name,$text)
    {
        return [
            "resourceType"=> "Composition",
            "identifier"=> [
                "system"=> "http://sys-ids.kemkes.go.id/composition/".$encounter->organization->ihs_number,
                "value"=> $kodeDiet
            ],
            "status"=> "final",
            "type"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> "18842-5",
                        "display"=> "Discharge summary"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://loinc.org",
                            "code"=> "LP173421-1",
                            "display"=> "Report"
                        ]
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
            "date"=> DateTimeFormat::dateNow(),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Resume Medis Rawat Jalan",
            "custodian"=> [
                "reference"=> "Organization/".$encounter->organization->ihs_number
            ],
            "section"=> [
                [
                    "code"=> [
                        "coding"=> [
                            [
                                "system"=> "http://hl7.org/fhir/sid/icd-10",
                                "code"=> $code,
                                "display"=> $name
                            ]
                        ]
                    ],
                    "text"=> [
                        "status"=> "additional",
                        "div"=> $text
                    ]
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$kodeDiet,$code,$name,$text)
    {
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "Composition",
            "identifier"=> [
                "system"=> "http://sys-ids.kemkes.go.id/composition/".$encounter->organization->ihs_number,
                "value"=> $kodeDiet
            ],
            "status"=> "final",
            "type"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> "18842-5",
                        "display"=> "Discharge summary"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://loinc.org",
                            "code"=> "LP173421-1",
                            "display"=> "Report"
                        ]
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
            "date"=> DateTimeFormat::dateParse($encounter->composition->created_at),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Resume Medis Rawat Jalan",
            "custodian"=> [
                "reference"=> "Organization/".$encounter->organization->ihs_number
            ],
            "section"=> [
                [
                    "code"=> [
                        "coding"=> [
                            [
                                "system"=> "http://hl7.org/fhir/sid/icd-10",
                                "code"=> $code,
                                "display"=> $name
                            ]
                        ]
                    ],
                    "text"=> [
                        "status"=> "additional",
                        "div"=> $text
                    ]
                ]
            ]
        ];
    }
}