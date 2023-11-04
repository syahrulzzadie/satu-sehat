<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Encounter
{
    public static function formCreateData($noRm,$noRawat,$organization,$patient,$practitioner,$location)
    {
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
                "start"=> DateTimeFormat::now()
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
                    "status"=> "arrived",
                    "period"=> [
                        "start"=> DateTimeFormat::now()
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$noRawat,
                    "value"=> $noRm
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$status,$createdAt,$noRm,$noRawat,$organization,$patient,$practitioner,$location)
    {
        $noRawat = StrHelper::cleanNoRawat($noRawat);
        return [
            "resourceType"=> "Encounter",
            "id"=> $ihsNumber,
            "status"=> $status,
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
                "start"=> DateTimeFormat::parse($createdAt)
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
                    "status"=> "arrived",
                    "period"=> [
                        "start"=> DateTimeFormat::parse($createdAt)
                    ]
                ],
                [
                    "status"=> $status,
                    "period"=> [
                        "start"=> DateTimeFormat::now()
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$noRawat,
                    "value"=> $noRm
                ]
            ]
        ];
    }
}