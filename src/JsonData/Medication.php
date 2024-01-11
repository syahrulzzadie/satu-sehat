<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Medication
{
    public static function formCreateData($noRawat, $kodeObat, $namaObat)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Medication",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/medication/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://sys-ids.kemkes.go.id/kfa",
                        "code"=> $kodeObat,
                        "display"=> $namaObat
                    ]
                ]
            ],
            "status"=> "active",
            "extension"=> [
                [
                    "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
                    "valueCodeableConcept"=> [
                        "coding"=> [
                            [
                                "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-type",
                                "code"=> "NC",
                                "display"=> "Non-compound"
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $noRawat, $kodeObat, $namaObat)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Medication",
            "id"=> $ihsNumber,
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/medication/".$organizationId,
                    "use"=> "official",
                    "value"=> $noRawat
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://sys-ids.kemkes.go.id/kfa",
                        "code"=> $kodeObat,
                        "display"=> $namaObat
                    ]
                ]
            ],
            "status"=> "active",
            "extension"=> [
                [
                    "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
                    "valueCodeableConcept"=> [
                        "coding"=> [
                            [
                                "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-type",
                                "code"=> "NC",
                                "display"=> "Non-compound"
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}