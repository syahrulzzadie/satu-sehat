<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Encounter
{
    public static function formCreateData($noRawat,$date,$time,$patient,$practitioner,$location)
    {
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
                "reference"=> "Organization/".$location->organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$location->organization->ihs_number,
                    "value"=> $noRawat
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$patient,$practitioner,$location)
    {
        $noRawat = StrHelper::cleanNoRawat($encounter->no_rawat);
        return [
            "resourceType"=> "Encounter",
            "id"=> $ihsNumber,
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
                "reference"=> "Organization/".$encounter->organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$encounter->organization->ihs_number,
                    "value"=> $noRawat
                ]
            ]
        ];
    }
}