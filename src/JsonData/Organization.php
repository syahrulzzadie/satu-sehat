<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Organization
{
    private static function typeCode($type)
    {
        if ($type == 'rs') {
            return [
                'code' => 'dept',
                'display' => 'Hospital Department'
            ];
        } else if($type == 'klinik') {
            return [
                'code' => 'crs',
                'display' => 'Clinical Research Sponsor'
            ];
        }
        return [
            'code' => 'other',
            'display' => 'Other'
        ];
    }
    public static function formCreateData($hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode)
    {
        $typeRs = self::typeCode($type);
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
                            "code"=> $typeRs['code'],
                            "display"=> $typeRs['display']
                        ]
                    ]
                ]
            ],
            "name"=> StrHelper::getName($name),
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> $phone,
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> $email,
                    "use"=> "work"
                ],
                [
                    "system"=> "url",
                    "value"=> $site,
                    "use"=> "work"
                ]
            ],
            "address"=> [
                [
                    "use"=> "work",
                    "type"=> "both",
                    "line"=> [ $address ],
                    "city"=> $city,
                    "postalCode"=> $postCode,
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
                "display"=> $hospitalName
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode)
    {
        $typeRs = self::typeCode($type);
        $organizationId = Enviroment::organizationId();
        return [
            "id"=> $ihsNumber,
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
                            "code"=> $typeRs['code'],
                            "display"=> $typeRs['display']
                        ]
                    ]
                ]
            ],
            "name"=> StrHelper::getName($name),
            "telecom"=> [
                [
                    "system"=> "phone",
                    "value"=> $phone,
                    "use"=> "work"
                ],
                [
                    "system"=> "email",
                    "value"=> $email,
                    "use"=> "work"
                ],
                [
                    "system"=> "url",
                    "value"=> $site,
                    "use"=> "work"
                ]
            ],
            "address"=> [
                [
                    "use"=> "work",
                    "type"=> "both",
                    "line"=> [ $address ],
                    "city"=> $city,
                    "postalCode"=> $postCode,
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
                "display"=> $hospitalName
            ]
        ];
    }
}
