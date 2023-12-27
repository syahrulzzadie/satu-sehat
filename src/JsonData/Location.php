<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Location
{
    public static function formCreateData($organization, $kode, $nama)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Location",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/location/".$organizationId,
                    "value"=> $kode
                ]
            ],
            "status"=> "active",
            "name"=> StrHelper::getName($nama),
            "description"=> StrHelper::getName($nama)." - RS Umum Islam Harapan Anda Kota Tegal",
            "mode"=> "instance",
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> "(0283) 358244",
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> "rsui@harapananda.com"
                ],
                [
                    "system"=> "url",
                    "value"=> "www.harapananda.com",
                    "use"=> "work"
                ]
            ],
            "address"=> [
                "use"=> "work",
                "line"=> ["Jl. Ababil No.42, Randugunting, Kec. Tegal Selatan, Kota Tegal, Jawa Tengah"],
                "city"=> "Kota Tegal",
                "postalCode"=> "52131",
                "country"=> "ID",
                "extension"=> [
                    [
                        "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension"=> [
                            [
                                "url"=> "province",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "city",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "district",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "village",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "rt",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "rw",
                                "valueCode"=> "0"
                            ]
                        ]
                    ]
                ]
            ],
            "physicalType"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code"=> "ro",
                        "display"=> "Room"
                    ]
                ]
            ],
            "position"=> [
                "longitude"=> -6.8758007,
                "latitude"=> 109.1261893,
                "altitude"=> 0
            ],
            "managingOrganization"=> [
                "reference"=> "Organization/".$organization->ihs_number,
                "display"=> $organization->name
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $organization, $kode, $nama)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Location",
            "id" => $ihsNumber,
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/location/".$organizationId,
                    "value"=> $kode
                ]
            ],
            "status"=> "active",
            "name"=> StrHelper::getName($nama),
            "description"=> StrHelper::getName($nama)." - RS Umum Islam Harapan Anda Kota Tegal",
            "mode"=> "instance",
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> "(0283) 358244",
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> "rsui@harapananda.com"
                ],
                [
                    "system"=> "url",
                    "value"=> "www.harapananda.com",
                    "use"=> "work"
                ]
            ],
            "address"=> [
                "use"=> "work",
                "line"=> ["Jl. Ababil No.42, Randugunting, Kec. Tegal Selatan, Kota Tegal, Jawa Tengah"],
                "city"=> "Kota Tegal",
                "postalCode"=> "52131",
                "country"=> "ID",
                "extension"=> [
                    [
                        "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension"=> [
                            [
                                "url"=> "province",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "city",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "district",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "village",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "rt",
                                "valueCode"=> "0"
                            ],
                            [
                                "url"=> "rw",
                                "valueCode"=> "0"
                            ]
                        ]
                    ]
                ]
            ],
            "physicalType"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code"=> "ro",
                        "display"=> "Room"
                    ]
                ]
            ],
            "position"=> [
                "longitude"=> -6.8758007,
                "latitude"=> 109.1261893,
                "altitude"=> 0
            ],
            "managingOrganization"=> [
                "reference"=> "Organization/".$organization->ihs_number,
                "display"=> $organization->name
            ]
        ];
    }
}
