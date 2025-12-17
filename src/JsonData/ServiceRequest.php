<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class ServiceRequest
{
    public static function formCreateData($noPermintaan,$encounter,$code,$name,$description)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType"=> "ServiceRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/servicerequest/".$organizationId,
                    "value"=> $noPermintaan
                ]
            ],
            "status"=> "completed",
            "intent"=> "order",
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ],
                "text"=> $description
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Kunjungan pasien ".$encounter->patient->name." pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "occurrenceDateTime"=> DateTimeFormat::parse($encounter->period_start)
        ];
    }

    public static function formUpdateData($ihsNumber,$noPermintaan,$encounter,$code,$name,$description)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "id"=> $ihsNumber,
            "resourceType"=> "ServiceRequest",
            "identifier"=> [
                [
                    "system"=> "http://sys-ids.kemkes.go.id/servicerequest/".$organizationId,
                    "value"=> $noPermintaan
                ]
            ],
            "status"=> "completed",
            "intent"=> "order",
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://snomed.info/sct",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ],
                "text"=> $description
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->ihs_number,
                "display"=> $encounter->patient->name
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->ihs_number,
                "display"=> "Kunjungan pasien ".$encounter->patient->name." pada ".StrHelper::dateTimeId($encounter->period_start)
            ],
            "occurrenceDateTime"=> DateTimeFormat::parse($encounter->period_start)
        ];
    }
}