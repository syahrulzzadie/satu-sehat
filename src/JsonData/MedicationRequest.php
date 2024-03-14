<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class MedicationRequest
{
    public static function formCreateData($encounter, $medication, $noRawat, $aturanPakai)
    {
        $organizationId = Enviroment::organizationId();
        $expiredYear = intval(date("Y")+1);
        return [
            "resourceType"=> "MedicationRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "status"=> "completed",
            "intent"=> "order",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
                            "code"=> "outpatient",
                            "display"=> "Outpatient"
                        ]
                    ]
                ]
            ],
            "priority"=> "routine",
            "medicationReference"=> [
                "reference"=> "Medication/".$medication->ihs_number,
                "display"=> $medication->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "authoredOn"=> DateTimeFormat::parse($encounter->period_start),
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
            ],
            "dosageInstruction"=> [
                [
                    "text"=> $aturanPakai,
                    "additionalInstruction"=> [
                        [
                            "text"=> $aturanPakai
                        ]
                    ],
                    "patientInstruction"=> $aturanPakai,
                    "timing"=> [
                        "repeat"=> [
                            "frequency"=> 1,
                            "period"=> 1,
                            "periodUnit"=> "d"
                        ]
                    ],
                    "route"=> [
                        "coding"=> [
                            [
                                "system"=> "http://www.whocc.no/atc",
                                "code"=> "O",
                                "display"=> "Oral"
                            ]
                        ]
                    ]
                ]
            ],
            "dispenseRequest"=> [
                "dispenseInterval"=> [
                    "value"=> 1,
                    "unit"=> "days",
                    "system"=> "http://unitsofmeasure.org",
                    "code"=> "d"
                ],
                "validityPeriod"=> [
                    "start"=> DateTimeFormat::now(),
                    "end"=> $expiredYear."-01-01T12:00:00+07:00"
                ],
                "numberOfRepeatsAllowed"=> 0,
                "quantity"=> [
                    "value"=> 1,
                    "unit"=> "TAB",
                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                    "code"=> "TAB"
                ],
                "expectedSupplyDuration"=> [
                    "value"=> 1,
                    "unit"=> "days",
                    "system"=> "http://unitsofmeasure.org",
                    "code"=> "d"
                ],
                "performer"=> [
                    "reference"=> "Organization/".$organizationId
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $encounter, $medication, $noRawat, $aturanPakai)
    {
        $organizationId = Enviroment::organizationId();
        $expiredYear = intval(date("Y")+1);
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "MedicationRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "status"=> "completed",
            "intent"=> "order",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
                            "code"=> "outpatient",
                            "display"=> "Outpatient"
                        ]
                    ]
                ]
            ],
            "priority"=> "routine",
            "medicationReference"=> [
                "reference"=> "Medication/".$medication->ihs_number,
                "display"=> $medication->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "authoredOn"=> DateTimeFormat::parse($encounter->period_start),
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
            ],
            "dosageInstruction"=> [
                [
                    "text"=> $aturanPakai,
                    "additionalInstruction"=> [
                        [
                            "text"=> $aturanPakai
                        ]
                    ],
                    "patientInstruction"=> $aturanPakai,
                    "timing"=> [
                        "repeat"=> [
                            "frequency"=> 1,
                            "period"=> 1,
                            "periodUnit"=> "d"
                        ]
                    ],
                    "route"=> [
                        "coding"=> [
                            [
                                "system"=> "http://www.whocc.no/atc",
                                "code"=> "O",
                                "display"=> "Oral"
                            ]
                        ]
                    ]
                ]
            ],
            "dispenseRequest"=> [
                "dispenseInterval"=> [
                    "value"=> 1,
                    "unit"=> "days",
                    "system"=> "http://unitsofmeasure.org",
                    "code"=> "d"
                ],
                "validityPeriod"=> [
                    "start"=> DateTimeFormat::now(),
                    "end"=> $expiredYear."-01-01T12:00:00+07:00"
                ],
                "numberOfRepeatsAllowed"=> 0,
                "quantity"=> [
                    "value"=> 1,
                    "unit"=> "TAB",
                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                    "code"=> "TAB"
                ],
                "expectedSupplyDuration"=> [
                    "value"=> 1,
                    "unit"=> "days",
                    "system"=> "http://unitsofmeasure.org",
                    "code"=> "d"
                ],
                "performer"=> [
                    "reference"=> "Organization/".$organizationId
                ]
            ]
        ];
    }
}