<?php

namespace syahrulzzadie\SatuSehat\JsonData;

class Medication
{
    public static function formCreateData($encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat)
    {
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
                    "system"=> "http://sys-ids.kemkes.go.id/medication/".$encounter->organization->ihs_number,
                    "use"=> "official",
                    "value"=> $noResep
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
                "reference"=> "Organization/".$encounter->organization->ihs_number
            ],
            "form"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code"=> $noResep,
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

    public static function formUpdateData($ihsNumber,$encounter,$noResep,$kodeObat,$namaObat,$dataBahanObat)
    {
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
                    "system"=> "http://sys-ids.kemkes.go.id/medication/".$encounter->organization->ihs_number,
                    "use"=> "official",
                    "value"=> $noResep
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
                "reference"=> "Organization/".$encounter->organization->ihs_number
            ],
            "form"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code"=> $noResep,
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