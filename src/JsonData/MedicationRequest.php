<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class MedicationRequest
{
    public static function formCreateData($encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "MedicationRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noResep
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
            "authoredOn"=> DateTimeFormat::dateNow(),
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
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
            "courseOfTherapyType"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
                        "code"=> "continuous",
                        "display"=> "Continuing long term therapy"
                    ]
                ]
            ],
            "dosageInstruction"=> [
                [
                    "sequence"=> 1,
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
                    ],
                    "doseAndRate"=> [
                        [
                            "type"=> [
                                "coding"=> [
                                    [
                                        "system"=> "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                        "code"=> "ordered",
                                        "display"=> "Ordered"
                                    ]
                                ]
                            ],
                            "doseQuantity"=> [
                                "value"=> $jumlahObatPerhari,
                                "unit"=> "TAB",
                                "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                                "code"=> "TAB"
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
                    "start"=> DateTimeFormat::dateNow(),
                    "end"=> DateTimeFormat::dateNow()
                ],
                "numberOfRepeatsAllowed"=> 0,
                "quantity"=> [
                    "value"=> $jumlahObatPerhari,
                    "unit"=> "TAB",
                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                    "code"=> "TAB"
                ],
                "expectedSupplyDuration"=> [
                    "value"=> $jumahHariObatHabis,
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

    public static function bundleFormCreateData($noRawat,$ihsNumberEncounter,$ihsNumberMedication,$date,$patient,$practitioner,$medication)
    {
        $organizationId = Enviroment::organizationId();
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
                "reference"=> "Medication/".$ihsNumberMedication
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$ihsNumberEncounter
            ],
            "authoredOn"=> DateTimeFormat::dateNow(),
            "requester"=> [
                "reference"=> "Practitioner/".$practitioner->ihs_number,
                "display"=> $practitioner->name
            ],
            "courseOfTherapyType"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
                        "code"=> "continuous",
                        "display"=> "Continuing long term therapy"
                    ]
                ]
            ],
            "dosageInstruction"=> [
                [
                    "sequence"=> 1,
                    "text"=> $medication['aturan_pakai'],
                    "additionalInstruction"=> [
                        [
                            "text"=> $medication['aturan_pakai']
                        ]
                    ],
                    "patientInstruction"=> $medication['aturan_pakai'],
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
                    ],
                    "doseAndRate"=> [
                        [
                            "type"=> [
                                "coding"=> [
                                    [
                                        "system"=> "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                        "code"=> "ordered",
                                        "display"=> "Ordered"
                                    ]
                                ]
                            ],
                            "doseQuantity"=> [
                                "value"=> $medication['jumlah_obat_perhari'],
                                "unit"=> "TAB",
                                "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                                "code"=> "TAB"
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
                    "start"=> DateTimeFormat::dateParse($date),
                    "end"=> DateTimeFormat::dateParse($date)
                ],
                "numberOfRepeatsAllowed"=> 0,
                "quantity"=> [
                    "value"=> $medication['jumlah_obat_perhari'],
                    "unit"=> "TAB",
                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                    "code"=> "TAB"
                ],
                "expectedSupplyDuration"=> [
                    "value"=> $medication['jumlah_hari_obat_habis'],
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

    public static function formUpdateData($ihsNumber,$encounter,$medication,$noResep,$aturanPakai,$jumlahObatPerhari,$jumahHariObatHabis)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "MedicationRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/prescription/".$organizationId,
                    "use"=> "official",
                    "value"=> $noResep
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
            "authoredOn"=> DateTimeFormat::dateNow(),
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
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
            "courseOfTherapyType"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
                        "code"=> "continuous",
                        "display"=> "Continuing long term therapy"
                    ]
                ]
            ],
            "dosageInstruction"=> [
                [
                    "sequence"=> 1,
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
                    ],
                    "doseAndRate"=> [
                        [
                            "type"=> [
                                "coding"=> [
                                    [
                                        "system"=> "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                        "code"=> "ordered",
                                        "display"=> "Ordered"
                                    ]
                                ]
                            ],
                            "doseQuantity"=> [
                                "value"=> $jumlahObatPerhari,
                                "unit"=> "TAB",
                                "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                                "code"=> "TAB"
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
                    "start"=> DateTimeFormat::dateNow(),
                    "end"=> DateTimeFormat::dateNow()
                ],
                "numberOfRepeatsAllowed"=> 0,
                "quantity"=> [
                    "value"=> $jumlahObatPerhari,
                    "unit"=> "TAB",
                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                    "code"=> "TAB"
                ],
                "expectedSupplyDuration"=> [
                    "value"=> $jumahHariObatHabis,
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