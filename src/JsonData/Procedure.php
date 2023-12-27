<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;

class Procedure
{
    public static function formCreateData($encounter,$code,$name,$text)
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
            "performedPeriod"=> [
                "start"=> DateTimeFormat::now(),
                "end"=> DateTimeFormat::now()
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                        "display"=> $encounter->practitioner->name
                    ]
                ]
            ],
            "reasonCode"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://hl7.org/fhir/sid/icd-10",
                            "code"=> $encounter->condition->code,
                            "display"=> $encounter->condition->name
                        ]
                    ]
                ]
            ],
            "bodySite"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://hl7.org/fhir/sid/icd-9-cm",
                            "code"=> $code,
                            "display"=> $name
                        ]
                    ]
                ]
            ],
            "note"=> [
                [
                    "text"=> $text
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$code,$name,$text)
    {
        return [
            "id" => $ihsNumber,
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
            "performedPeriod"=> [
                "start"=> DateTimeFormat::now(),
                "end"=> DateTimeFormat::now()
            ],
            "performer"=> [
                [
                    "actor"=> [
                        "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                        "display"=> $encounter->practitioner->name
                    ]
                ]
            ],
            "reasonCode"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://hl7.org/fhir/sid/icd-10",
                            "code"=> $encounter->condition->code,
                            "display"=> $encounter->condition->name
                        ]
                    ]
                ]
            ],
            "bodySite"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://hl7.org/fhir/sid/icd-9-cm",
                            "code"=> $code,
                            "display"=> $name
                        ]
                    ]
                ]
            ],
            "note"=> [
                [
                    "text"=> $text
                ]
            ]
        ];
    }
}