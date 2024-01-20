<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class ServiceRequest
{
    public static function formCreateData($noRawat,$encounter,$location,$performer)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/servicerequest/".$organizationId,
                    "value"=> $noRawat
                ]
            ],
            "resourceType"=> "ServiceRequest",
            "status"=> "active",
            "intent"=> "original-order",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://snomed.info/sct",
                            "code"=> "306098008",
                            "display"=> "Self-referral"
                        ]
                    ]
                ],
                [
                    "coding"=> [
                        [
                            "system"=> "http://snomed.info/sct",
                            "code"=> "11429006",
                            "display"=> "Consultation"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> "185389009",
                        "display"=> "Follow-up visit"
                    ]
                ],
                "text"=> "Rujuk Internal pasien ".$encounter->patient->name. " ke ".$location->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Kunjungan pasien ".$encounter->patient->name." pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
            ],
            "performer"=> [
                "reference"=> "Practitioner/".$performer->ihs_number,
                "display"=> $performer->name
            ],
            "locationCode"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/v3-RoleCode",
                            "code"=> "OF",
                            "display"=> "Outpatient Facility"
                        ]
                    ]
                ]
            ],
            "locationReference"=> [
                [
                    "reference"=> "Location/".$location->ihs_number,
                    "display"=> $location->name
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$noRawat,$encounter,$location,$performer)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "id" => $ihsNumber,
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/servicerequest/".$organizationId,
                    "value"=> $noRawat
                ]
            ],
            "resourceType"=> "ServiceRequest",
            "status"=> "active",
            "intent"=> "original-order",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://snomed.info/sct",
                            "code"=> "306098008",
                            "display"=> "Self-referral"
                        ]
                    ]
                ],
                [
                    "coding"=> [
                        [
                            "system"=> "http://snomed.info/sct",
                            "code"=> "11429006",
                            "display"=> "Consultation"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> "185389009",
                        "display"=> "Follow-up visit"
                    ]
                ],
                "text"=> "Rujuk Internal pasien ".$encounter->patient->name. " ke ".$location->name
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Kunjungan pasien ".$encounter->patient->name." pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "requester"=> [
                "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                "display"=> $encounter->practitioner->name
            ],
            "performer"=> [
                "reference"=> "Practitioner/".$performer->ihs_number,
                "display"=> $performer->name
            ],
            "locationCode"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/v3-RoleCode",
                            "code"=> "OF",
                            "display"=> "Outpatient Facility"
                        ]
                    ]
                ]
            ],
            "locationReference"=> [
                [
                    "reference"=> "Location/".$location->ihs_number,
                    "display"=> $location->name
                ]
            ]
        ];
    }
}