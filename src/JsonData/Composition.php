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
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Diet pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "date"=> DateTimeFormat::dateNow(),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Diet Pasien",
            "custodian"=> [
                "reference"=> "Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda"
            ],
            "section"=> [
                [
                    "code"=> [
                        "coding"=> [
                            [
                                "system"=> "http://loinc.org",
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
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Diet pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "date"=> DateTimeFormat::dateParse($encounter->period_start),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Diet Pasien",
            "custodian"=> [
                "reference"=> "Organization/".$encounter->organization->ihs_number,
                "display"=> "RS Umum Islam Harapan Anda"
            ],
            "section"=> [
                [
                    "code"=> [
                        "coding"=> [
                            [
                                "system"=> "http://loinc.org",
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