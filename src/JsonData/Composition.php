<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Composition
{
    public static function formCreateData($encounter,$noRawat,$code,$name,$text)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Composition",
            "identifier"=> [
                "system"=> "http://sys-ids.kemkes.go.id/composition/".$organizationId,
                "value"=> $noRawat
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
                "reference"=> "Organization/".$organizationId
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

    public static function bundleFormCreateData($ihsNumberEncounter,$noRawat,$date,$patient,$practitioner,$composition)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Composition",
            "identifier"=> [
                "system"=> "http://sys-ids.kemkes.go.id/composition/".$organizationId,
                "value"=> $noRawat
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
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$ihsNumberEncounter
            ],
            "date"=> DateTimeFormat::dateParse($date),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "title"=> "Resume Medis Rawat Jalan",
            "custodian"=> [
                "reference"=> "Organization/".$organizationId
            ],
            "section"=> [
                [
                    "code"=> [
                        "coding"=> [
                            [
                                "system"=> "http://hl7.org/fhir/sid/icd-10",
                                "code"=> $composition['code'],
                                "display"=> $composition['name']
                            ]
                        ]
                    ],
                    "text"=> [
                        "status"=> "additional",
                        "div"=> $composition['text']
                    ]
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$noRawat,$code,$name,$text)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "Composition",
            "identifier"=> [
                "system"=> "http://sys-ids.kemkes.go.id/composition/".$organizationId,
                "value"=> $noRawat
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