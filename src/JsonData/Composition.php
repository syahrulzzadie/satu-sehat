<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Composition
{
    public static function formCreateData($encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi)
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
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Resume Medis Pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "date"=> DateTimeFormat::now(),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Resume Medis Pasien",
            "custodian"=> [
                "reference"=> "Organization/".$organizationId
            ],
            "section"=> [
                [
                    "title" => "Ringkasan Masuk",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($subjective)
                    ]
                ],
                [
                    "title" => "Pemeriksaan Fisik",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($objective)
                    ]
                ],
                [
                    "title" => "Diagnosis",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($analisys)
                    ]
                ],
                [
                    "title" => "Terapi Saat Perawatan",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($planning)
                    ]
                ],
                [
                    "title" => "Instruksi",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($instruksi)
                    ]
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi)
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
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Resume Medis pasien ".$encounter->patient->name." pada ".$encounter->period_start
            ],
            "date"=> DateTimeFormat::parse($encounter->period_start),
            "author"=> [
                [
                    "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                    "display"=> $encounter->practitioner->name
                ]
            ],
            "title"=> "Resume Medis Pasien",
            "custodian"=> [
                "reference"=> "Organization/".$organizationId
            ],
            "section"=> [
                [
                    "title" => "Ringkasan Masuk",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($subjective)
                    ]
                ],
                [
                    "title" => "Pemeriksaan Fisik",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($objective)
                    ]
                ],
                [
                    "title" => "Diagnosis",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($analisys)
                    ]
                ],
                [
                    "title" => "Terapi Saat Perawatan",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($planning)
                    ]
                ],
                [
                    "title" => "Instruksi",
                    "text" => [
                        "status" => "generated",
                        "div" => nl2br($instruksi)
                    ]
                ]
            ]
        ];
    }
}