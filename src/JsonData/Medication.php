<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;

class Medication
{
    public static function formCreateData($noRawat,$kodeObat,$namaObat,$dataBahanObat)
    {
        $organizationId = Enviroment::organizationId();
        $dataBahan = [];
        foreach($dataBahanObat as $item) {
            $dataBahan[] = [
                "itemCodeableConcept"=> [
                    "coding"=> [
                        [
                            "system"=> "http://sys-ids.kemkes.go.id/kfa",
                            "code"=> $item['kode_bahan'],
                            "display"=> $item['nama_bahan']
                        ]
                    ]
                ],
                "isActive"=> true,
                "strength"=> [
                    "numerator"=> [
                        "value"=> $item['berat'],
                        "system"=> "http://unitsofmeasure.org",
                        "code"=> $item['satuan_berat']
                    ],
                    "denominator"=> [
                        "value"=> $item['jumlah'],
                        "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                        "code"=> $item['satuan_jumlah']
                    ]
                ]
            ];
        }
        return [
            "resourceType"=> "Medication",
            "meta"=> [
                "profile"=> [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
                ]
            ],
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
            "manufacturer"=> [
                "reference"=> "Organization/".$organizationId
            ],
            "form"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code"=> $noRawat,
                        "display"=> "Resep Obat Pasien"
                    ]
                ]
            ],
            "ingredient"=> $dataBahan,
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

    public static function formUpdateData($ihsNumber,$noRawat,$kodeObat,$namaObat,$dataBahanObat)
    {
        $organizationId = Enviroment::organizationId();
        $dataBahan = [];
        foreach($dataBahanObat as $item) {
            $dataBahan[] = [
                "itemCodeableConcept"=> [
                    "coding"=> [
                        [
                            "system"=> "http://sys-ids.kemkes.go.id/kfa",
                            "code"=> $item['kode_bahan'],
                            "display"=> $item['nama_bahan']
                        ]
                    ]
                ],
                "isActive"=> true,
                "strength"=> [
                    "numerator"=> [
                        "value"=> $item['berat'],
                        "system"=> "http://unitsofmeasure.org",
                        "code"=> $item['satuan_berat']
                    ],
                    "denominator"=> [
                        "value"=> $item['jumlah'],
                        "system"=> "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                        "code"=> $item['satuan_jumlah']
                    ]
                ]
            ];
        }
        return [
            "resourceType"=> "Medication",
            "id"=> $ihsNumber,
            "meta"=> [
                "profile"=> [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
                ]
            ],
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
            "manufacturer"=> [
                "reference"=> "Organization/".$organizationId
            ],
            "form"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code"=> $noRawat,
                        "display"=> "Resep Obat Pasien"
                    ]
                ]
            ],
            "ingredient"=> $dataBahan,
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