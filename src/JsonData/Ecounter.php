<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Ecounter
{
    public static function formCreateData($organization,$patient,$practitioner,$location)
    {
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
                "start"=> date('Y-m-dTH:i:s+07:00')
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
                        "start"=> date('Y-m-dTH:i:s+07:00')
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$organization->ihs_number,
                    "value"=> $patient->ihs_number
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$organization,$patient,$practitioner,$location)
    {
        return [
            "resourceType"=> "Encounter",
            "id"=> $ihsNumber,
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
                "start"=> date('Y-m-dTH:i:s+07:00')
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
                        "start"=> date('Y-m-dTH:i:s+07:00')
                    ]
                ]
            ],
            "serviceProvider"=> [
                "reference"=> "Organization/".$organization->ihs_number
            ],
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/encounter/".$organization->ihs_number,
                    "value"=> $patient->ihs_number
                ]
            ]
        ];
    }
}