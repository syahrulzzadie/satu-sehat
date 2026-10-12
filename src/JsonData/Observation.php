<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Observation
{
    public static function formCreateData($encounter,$practitioner,$name,$value,$effectiveDateTime = null)
    {
        $ttv = StrHelper::getTtv($name,$value);
        return [
            "resourceType"=> "Observation",
            "status"=> "final",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                            "code"=> "vital-signs",
                            "display"=> "Vital Signs"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> $ttv['code_ttv'],
                        "display"=> $ttv['name_ttv']
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "issued"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['unit'],
                "code"=> $ttv['code']
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$practitioner,$name,$value,$effectiveDateTime = null)
    {
        $ttv = StrHelper::getTtv($name,$value);
        return [
            "resourceType"=> "Observation",
            "id"=> $ihsNumber,
            "status"=> "final",
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                            "code"=> "vital-signs",
                            "display"=> "Vital Signs"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> $ttv['code_ttv'],
                        "display"=> $ttv['name_ttv']
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ]
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Pemeriksaan fisik pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "issued"=> DateTimeFormat::parse($effectiveDateTime ?? $encounter->period_start),
            "valueQuantity"=> [
                "system"=> "http://unitsofmeasure.org",
                "value"=> $ttv['value'],
                "unit"=> $ttv['unit'],
                "code"=> $ttv['code']
            ]
        ];
    }

    /**
     * Observation hasil laboratorium (category laboratory) - dirujuk oleh DiagnosticReport lab.
     *
     * $value string -> valueString. $value array -> hasil terstruktur satu pemeriksaan:
     *   'value' + 'unit' (+ 'unit_code' UCUM)  -> valueQuantity, tanpa 'value' -> valueString dari 'text'
     *   'low' / 'high' / 'reference_text'      -> referenceRange (opsional)
     *   'interpretation' H|L|N|A|HH|LL         -> interpretation (opsional)
     */
    public static function formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,is_array($value) ? '' : $value,$effectiveDateTime,$issuedDateTime);
        if (is_array($value)) {
            $formData = self::nilaiTerstruktur($formData,$value);
        }
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                        "code"=> "laboratory",
                        "display"=> "Laboratory"
                    ]
                ]
            ]
        ];
        if (!empty($specimenIhs)) {
            $formData["specimen"] = [
                "reference"=> "Specimen/".$specimenIhs
            ];
        }
        return $formData;
    }

    /**
     * Observation hasil bacaan radiologi (category imaging) - dirujuk oleh DiagnosticReport radiologi.
     */
    public static function formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime);
        $formData["category"] = [
            [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/observation-category",
                        "code"=> "imaging",
                        "display"=> "Imaging"
                    ]
                ]
            ]
        ];
        return $formData;
    }

    public static function formUpdateDataLab($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $formData = self::formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime);
        return ["id"=> $ihsNumber] + $formData;
    }

    private const INTERPRETASI = [
        'H' => 'High', 'L' => 'Low', 'N' => 'Normal', 'A' => 'Abnormal', 'HH' => 'Critical high', 'LL' => 'Critical low'
    ];

    private static function kuantitas($nilai,$value)
    {
        $kuantitas = ["value"=> (float) $nilai];
        if (!empty($value['unit'])) {
            $kuantitas["unit"] = $value['unit'];
            if (!empty($value['unit_code'])) {
                $kuantitas["system"] = "http://unitsofmeasure.org";
                $kuantitas["code"] = $value['unit_code'];
            }
        }
        return $kuantitas;
    }

    private static function nilaiTerstruktur($formData,array $value)
    {
        unset($formData["valueString"]);
        if (isset($value['value']) && is_numeric($value['value'])) {
            $formData["valueQuantity"] = self::kuantitas($value['value'],$value);
        } else {
            $formData["valueString"] = (string) ($value['text'] ?? '');
        }
        $rentang = [];
        foreach (['low','high'] as $batas) {
            if (isset($value[$batas]) && is_numeric($value[$batas])) {
                $rentang[$batas] = self::kuantitas($value[$batas],$value);
            }
        }
        if (!empty($value['reference_text'])) {
            $rentang["text"] = $value['reference_text'];
        }
        if ($rentang) {
            $formData["referenceRange"] = [$rentang];
        }
        $interpretasi = strtoupper(trim((string) ($value['interpretation'] ?? '')));
        if (isset(self::INTERPRETASI[$interpretasi])) {
            $formData["interpretation"] = [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
                            "code"=> $interpretasi,
                            "display"=> self::INTERPRETASI[$interpretasi]
                        ]
                    ]
                ]
            ];
        }
        return $formData;
    }

    private static function baseResultData($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "Observation",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/observation/".$organizationId,
                    "value"=> $noPermintaan
                ]
            ],
            "status"=> "final",
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://loinc.org",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number
            ],
            "effectiveDateTime"=> DateTimeFormat::parse($effectiveDateTime),
            "issued"=> DateTimeFormat::parse($issuedDateTime ?? $effectiveDateTime),
            "performer"=> [
                [
                    "reference"=> "Practitioner/".$practitioner->ihs_number,
                    "display"=> $practitioner->name
                ],
                [
                    "reference"=> "Organization/".$organizationId
                ]
            ],
            "basedOn"=> [
                [
                    "reference"=> "ServiceRequest/".$serviceRequestIhs
                ]
            ],
            "valueString"=> $value
        ];
    }
}