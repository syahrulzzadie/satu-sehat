<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Encounter
{
    public static function formCreateData($noRawat,$date,$time,$patient,$practitioner,$location)
    {
        $organizationId = Enviroment::organizationId();
        $noRawat = StrHelper::cleanNoRawat($noRawat);
        return [
            "resourceType"=> "Encounter",
            "status"=> "finished",
            "class"=> [
                "system"=> "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code"=> "AMB",
                "display"=> "ambulatory"
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "participant"=> [
                [
                    "type"=> [
                        [
                            "coding"=> [
                                [
                                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code"=> "ATND",
                                    "display"=> "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual"=> [
                        "reference"=> "Practitioner/".$practitioner->ihs_number,
                        "display"=> $practitioner->name
                    ]
                ]
            ],
            "period"=> [
                "start"=> DateTimeFormat::parseDateAndTime($date,$time),
                "end"=> DateTimeFormat::parseDateAndTime($date,$time)
            ],
            "location"=> [
                [
                    "location"=> [
                        "reference"=> "Location/".$location->ihs_number,
                        "display"=> $location->name
                    ]
                ]
            ],
            "statusHistory"=> [
                [
                    "status"=> "finished",
                    "period"=> [
                        "start"=> DateTimeFormat::parseDateAndTime($date,$time),
                        "end"=> DateTimeFormat::parseDateAndTime($date,$time)
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda Kota Tegal"
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$organizationId,
                    "value"=> $noRawat
                ]
            ]
        ];
    }

    public static function formUpdateData($encounter,$patient,$practitioner,$location)
    {
        $organizationId = Enviroment::organizationId();
        $noRawat = StrHelper::cleanNoRawat($encounter->no_rawat);
        return [
            "resourceType"=> "Encounter",
            "id"=> $encounter->ihs_number,
            "status"=> 'finished',
            "class"=> [
                "system"=> "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code"=> "AMB",
                "display"=> "ambulatory"
            ],
            "subject"=> [
                "reference"=> "Patient/".$patient->ihs_number,
                "display"=> $patient->name
            ],
            "participant"=> [
                [
                    "type"=> [
                        [
                            "coding"=> [
                                [
                                    "system"=> "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code"=> "ATND",
                                    "display"=> "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual"=> [
                        "reference"=> "Practitioner/".$practitioner->ihs_number,
                        "display"=> $practitioner->name
                    ]
                ]
            ],
            "period"=> [
                "start"=> DateTimeFormat::parse($encounter->period_start),
                "end"=> DateTimeFormat::parse($encounter->period_end)
            ],
            "location"=> [
                [
                    "location"=> [
                        "reference"=> "Location/".$location->ihs_number,
                        "display"=> $location->name
                    ]
                ]
            ],
            "statusHistory"=> [
                [
                    "status"=> 'finished',
                    "period"=> [
                        "start"=> DateTimeFormat::parse($encounter->period_start),
                        "end"=> DateTimeFormat::parse($encounter->period_end)
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda Kota Tegal"
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$organizationId,
                    "value"=> $noRawat
                ]
            ]
        ];
    }
}