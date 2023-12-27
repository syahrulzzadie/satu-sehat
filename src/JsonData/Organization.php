<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Organization
{
    public static function formCreateData($kode, $name)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Organization",
            "active"=> true,
            "identifier"=> [
                [
                    "use"=> "official",
                    "system"=> "http://sys-ids.kemkes.go.id/organization/".$organizationId,
                    "value"=> $kode
                ]
            ],
            "type"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code"=> "dept",
                            "display"=> "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name"=> ucwords(strtolower($name)),
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> "(0283) 358244",
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> "rsui@harapananda.com",
                    "use"=> "work"
                ],
                [
                    "system"=> "url",
                    "value"=> "www.harapananda.com",
                    "use"=> "work"
                ]
            ],
            "address"=> [
                [
                    "use"=> "work",
                    "type"=> "both",
                    "line"=> [ "Jl. Ababil No.42, Randugunting, Kec. Tegal Selatan, Kota Tegal, Jawa Tengah" ],
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
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf"=> [
                "reference"=> "Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda Kota Tegal"
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $kode, $name)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Organization",
            "id" => $ihsNumber,
            "active"=> true,
            "identifier"=> [
                [
                    "use"=> "official",
                    "system"=> "http://sys-ids.kemkes.go.id/organization/".$organizationId,
                    "value"=> $kode
                ]
            ],
            "type"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code"=> "dept",
                            "display"=> "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name"=> ucwords(strtolower($name)),
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> "(0283) 358244",
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> "rsui@harapananda.com",
                    "use"=> "work"
                ],
                [
                    "system"=> "url",
                    "value"=> "www.harapananda.com",
                    "use"=> "work"
                ]
            ],
            "address"=> [
                [
                    "use"=> "work",
                    "type"=> "both",
                    "line"=> [ "Jalan Ababil 42" ],
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
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf"=> [
                "reference"=> "Organization/".$organizationId,
                "display"=> "RS Umum Islam Harapan Anda Kota Tegal"
            ]
        ];
    }
}
