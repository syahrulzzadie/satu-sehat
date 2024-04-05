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
            "status"=> "arrived",
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
            "status"=> 'arrived',
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

    public static function formCancelData($encounter,$patient,$practitioner,$location)
    {
        $organizationId = Enviroment::organizationId();
        $noRawat = StrHelper::cleanNoRawat($encounter->no_rawat);
        return [
            "resourceType"=> "Encounter",
            "id"=> $encounter->ihs_number,
            "status"=> 'cancelled',
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

    public static function formUpdateCondition($encounter,$dataDiagnosis)
    {
        $diagnosis = [];
        foreach ($dataDiagnosis as $item) {
            $diagnosis[] = [
                "condition"=> [
                    "reference"=> "Condition/".$item['ihs_number'],
                    "display"=> $item['code_name']
                ],
                "use"=> [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                            "code"=> $item['code'],
                            "display"=> $item['name']
                        ]
                    ]
                ],
                "rank"=> $item['rank']
            ];
        }
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Encounter",
            "id"=> $encounter->ihs_number,
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$organizationId,
                    "value"=> $encounter->no_rawat
                ]
            ],
            "status"=> "finished",
            "class"=> [
                "system"=> "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code"=> "AMB",
                "display"=> "ambulatory"
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
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
                        "reference"=> "Practitioner/".$encounter->practitioner->ihs_number,
                        "display"=> $encounter->practitioner->name
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
                        "reference"=> "Location/".$encounter->location->ihs_number,
                        "display"=> $encounter->location->name
                    ]
                ]
            ],
            "diagnosis"=> $diagnosis,
            "statusHistory"=> [
                [
                    "status"=> "arrived",
                    "period"=> [
                        "start"=> DateTimeFormat::parse($encounter->period_start),
                        "end"=> DateTimeFormat::parse($encounter->period_end)
                    ]
                ],
                [
                    "status"=> "finished",
                    "period"=> [
                        "start"=> DateTimeFormat::parse($encounter->period_start),
                        "end"=> DateTimeFormat::parse($encounter->period_end)
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=>"Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda Kota Tegal"
            ]
        ];
    }
}