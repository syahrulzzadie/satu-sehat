<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\DateTimeFormat;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\Fhir;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

/**
 * Encounter sesuai Postman SATUSEHAT.
 *
 * Rawat jalan (01): POST arrived -> PUT in-progress -> PUT finished.
 * Rawat inap (02) : POST planned/in-progress -> PUT pindah ruang / ganti DPJP -> PUT finished.
 * Semua variasi dibangun oleh formData(); method lain hanya pembungkus.
 *
 * $options (opsional, semua key boleh dihilangkan):
 * - serviceType      : [system, code, display] mis. [Fhir::SNOMED, '419192003', 'Internal medicine']
 * - serviceClass     : kelas layanan lokasi, mis. 'reguler' (rawat jalan) / '1','2','3','vip' (rawat inap)
 * - upgradeClass     : 'kelas-tetap' | 'naik-kelas' | 'turun-kelas' | 'titip-rawat'
 * - toFacility       : 'new' | 'returning'  (extension EncounterToFacility)
 * - toSpecialty      : 'new' | 'returning'  (extension EncounterToSpecialty)
 * - toEpisode        : 'new' | 'returning'  (extension EncounterToEpisode)
 * - healthcareService: id HealthcareService
 * - episodeOfCare    : id EpisodeOfCare (program, mis. ANC/TB)
 * - basedOn          : id ServiceRequest (mis. rujukan / surat perintah rawat inap)
 * - dischargeDisposition: [code, display, text] system discharge-disposition, mis. ['home', 'Home', 'Pulang dan kontrol']
 */
class Encounter
{
    private static $serviceClassSystem = [
        'AMB' => 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient',
        'EMER' => 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient',
        'IMP' => 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Inpatient'
    ];

    private static $serviceClassDisplay = [
        'reguler' => 'Kelas Reguler',
        'eksekutif' => 'Kelas Eksekutif',
        '1' => 'Kelas 1',
        '2' => 'Kelas 2',
        '3' => 'Kelas 3',
        'vip' => 'Kelas VIP',
        'vvip' => 'Kelas VVIP'
    ];

    private static $upgradeClassDisplay = [
        'kelas-tetap' => 'Kelas Tetap Perawatan',
        'naik-kelas' => 'Kenaikan Kelas Perawatan',
        'turun-kelas' => 'Penurunan Kelas Perawatan',
        'titip-rawat' => 'Titip Kelas Perawatan'
    ];

    private static $participantType = [
        'ATND' => 'attender',
        'ADM' => 'admitter',
        'CON' => 'consultant',
        'DIS' => 'discharger',
        'REF' => 'referrer',
        'SPRF' => 'secondary performer',
        'PPRF' => 'primary performer'
    ];

    /**
     * Builder Encounter fleksibel.
     *
     * $data:
     * - no_rawat      : nomor registrasi lokal (identifier)
     * - ihs_number    : id Encounter (wajib untuk PUT)
     * - status        : planned | arrived | in-progress | finished | cancelled
     * - class         : AMB | EMER | IMP (default AMB)
     * - patient       : objek (ihs_number, name)
     * - period        : [start, end]  (end boleh null)
     * - statusHistory : [[status, start, end], ...]
     * - locations     : [['location' => obj, 'start' => .., 'end' => .., 'serviceClass' => .., 'upgradeClass' => ..], ...]
     * - participants  : [['practitioner' => obj, 'type' => 'ATND', 'start' => .., 'end' => ..], ...]
     * - diagnosis     : [['ihs_number' => .., 'code_name' => .., 'rank' => 1, 'use' => 'DD'], ...]
     * - hospitalName  : display serviceProvider
     * + semua key $options (lihat docblock kelas)
     */
    public static function formData(array $data)
    {
        $classCode = strtoupper($data['class'] ?? 'AMB');
        $period = $data['period'] ?? [];
        $start = DateTimeFormat::parse($period[0]);
        $end = !empty($period[1]) ? DateTimeFormat::parse($period[1]) : null;

        $statusHistory = [];
        foreach ($data['statusHistory'] ?? [] as $history) {
            $statusHistory[] = [
                "status"=> $history[0],
                "period"=> Fhir::period($history[1], $history[2] ?? null)
            ];
        }

        $locations = [];
        foreach ($data['locations'] ?? [] as $item) {
            $locations[] = self::location($item, $classCode, $data);
        }

        $participants = [];
        foreach ($data['participants'] ?? [] as $item) {
            $type = $item['type'] ?? 'ATND';
            $participants[] = [
                "type"=> [Fhir::concept("http://terminology.hl7.org/CodeSystem/v3-ParticipationType",$type,self::$participantType[$type] ?? null)],
                "individual"=> Fhir::practitioner($item['practitioner']),
                "period"=> !empty($item['start']) ? Fhir::period($item['start'], $item['end'] ?? null) : null
            ];
        }

        $length = null;
        if ($end && ($data['status'] ?? '') == 'finished') {
            $length = Fhir::quantity(max(0, intval(round((strtotime($end) - strtotime($start)) / 60))), 'min');
        }

        $serviceType = $data['serviceType'] ?? null;
        return Fhir::clean([
            "resourceType"=> "Encounter",
            "id"=> $data['ihs_number'] ?? null,
            "identifier"=> [
                Fhir::identifier('encounter', StrHelper::cleanNoRawat($data['no_rawat']))
            ],
            "status"=> $data['status'],
            "class"=> StrHelper::encounterClass($classCode),
            "serviceType"=> $serviceType ? Fhir::concept($serviceType[0],$serviceType[1],$serviceType[2] ?? null) : null,
            "subject"=> Fhir::reference('Patient',$data['patient']->ihs_number,$data['patient']->name ?? null),
            "participant"=> $participants,
            "basedOn"=> !empty($data['basedOn']) ? [Fhir::reference('ServiceRequest',$data['basedOn'])] : null,
            "episodeOfCare"=> !empty($data['episodeOfCare']) ? [Fhir::reference('EpisodeOfCare',$data['episodeOfCare'])] : null,
            "period"=> ["start"=> $start, "end"=> $end],
            "length"=> $length,
            "location"=> $locations,
            "diagnosis"=> self::diagnosis($data['diagnosis'] ?? []),
            "statusHistory"=> $statusHistory,
            "hospitalization"=> self::hospitalization($data),
            "serviceProvider"=> Fhir::organization($data['hospitalName'] ?? null),
            "extension"=> self::extensions($data)
        ]);
    }

    public static function formCreateData($noRawat,$date,$time,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $start = DateTimeFormat::parseDateAndTime($date,$time);
        return self::formData($options + [
            'no_rawat' => $noRawat,
            'status' => 'arrived',
            'class' => $classCode,
            'patient' => $patient,
            'period' => [$start],
            'statusHistory' => [['arrived', $start]],
            'locations' => [['location' => $location, 'start' => $start]],
            'participants' => [['practitioner' => $practitioner]],
            'hospitalName' => $hospitalName
        ]);
    }

    /**
     * Pasien masuk ruang pemeriksaan (arrived -> in-progress).
     */
    public static function formInProgressData($encounter,$inProgressDateTime,$hospitalName,$classCode = 'AMB',$options = [])
    {
        return self::formData($options + [
            'ihs_number' => $encounter->ihs_number,
            'no_rawat' => $encounter->no_rawat,
            'status' => 'in-progress',
            'class' => $classCode,
            'patient' => $encounter->patient,
            'period' => [$encounter->period_start],
            'statusHistory' => [
                ['arrived', $encounter->period_start, $inProgressDateTime],
                ['in-progress', $inProgressDateTime]
            ],
            'locations' => [['location' => $encounter->location, 'start' => $encounter->period_start]],
            'participants' => [['practitioner' => $encounter->practitioner]],
            'hospitalName' => $hospitalName
        ]);
    }

    /**
     * Kunjungan selesai: arrived -> in-progress -> finished, dengan diagnosis & cara pulang.
     * $dataDiagnosis: [['ihs_number' => ..., 'code_name' => ..., 'rank' => 1, 'use' => 'DD'|'CC'|...], ...]
     */
    public static function formFinishedData($encounter,$dataDiagnosis,$inProgressDateTime,$finishedDateTime,$hospitalName,$classCode = 'AMB',$options = [])
    {
        return self::formData($options + [
            'ihs_number' => $encounter->ihs_number,
            'no_rawat' => $encounter->no_rawat,
            'status' => 'finished',
            'class' => $classCode,
            'patient' => $encounter->patient,
            'period' => [$encounter->period_start, $finishedDateTime],
            'statusHistory' => [
                ['arrived', $encounter->period_start, $inProgressDateTime],
                ['in-progress', $inProgressDateTime, $finishedDateTime],
                ['finished', $finishedDateTime, $finishedDateTime]
            ],
            'locations' => [['location' => $encounter->location, 'start' => $encounter->period_start, 'end' => $finishedDateTime]],
            'participants' => [['practitioner' => $encounter->practitioner]],
            'diagnosis' => $dataDiagnosis,
            'hospitalName' => $hospitalName
        ]);
    }

    public static function formUpdateData($encounter,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        return self::formData($options + [
            'ihs_number' => $encounter->ihs_number,
            'no_rawat' => $encounter->no_rawat,
            'status' => 'arrived',
            'class' => $classCode,
            'patient' => $patient,
            'period' => [$encounter->period_start],
            'statusHistory' => [['arrived', $encounter->period_start]],
            'locations' => [['location' => $location, 'start' => $encounter->period_start]],
            'participants' => [['practitioner' => $practitioner]],
            'hospitalName' => $hospitalName
        ]);
    }

    public static function formCancelData($encounter,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $end = !empty($encounter->period_end) ? $encounter->period_end : $encounter->period_start;
        return self::formData($options + [
            'ihs_number' => $encounter->ihs_number,
            'no_rawat' => $encounter->no_rawat,
            'status' => 'cancelled',
            'class' => $classCode,
            'patient' => $patient,
            'period' => [$encounter->period_start, $end],
            'statusHistory' => [
                ['arrived', $encounter->period_start, $end],
                ['cancelled', $end, $end]
            ],
            'locations' => [['location' => $location, 'start' => $encounter->period_start, 'end' => $end]],
            'participants' => [['practitioner' => $practitioner]],
            'hospitalName' => $hospitalName
        ]);
    }

    /**
     * Versi lama (dipertahankan): selesai kunjungan memakai period_start / period_end encounter.
     * Pasien dianggap masuk ruang periksa saat period_start.
     */
    public static function formUpdateCondition($encounter,$dataDiagnosis,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $end = !empty($encounter->period_end) ? $encounter->period_end : $encounter->period_start;
        return self::formFinishedData($encounter,$dataDiagnosis,$encounter->period_start,$end,$hospitalName,$classCode,$options);
    }

    private static function location($item,$classCode,$data)
    {
        $location = $item['location'];
        $serviceClass = $item['serviceClass'] ?? ($data['serviceClass'] ?? null);
        $extension = null;
        if ($serviceClass) {
            $upgradeClass = $item['upgradeClass'] ?? ($data['upgradeClass'] ?? 'kelas-tetap');
            $extension = [
                [
                    "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                    "extension"=> [
                        [
                            "url"=> "value",
                            "valueCodeableConcept"=> Fhir::concept(
                                self::$serviceClassSystem[$classCode] ?? self::$serviceClassSystem['AMB'],
                                $serviceClass,
                                self::$serviceClassDisplay[$serviceClass] ?? null
                            )
                        ],
                        [
                            "url"=> "upgradeClassIndicator",
                            "valueCodeableConcept"=> Fhir::concept(
                                "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                $upgradeClass,
                                self::$upgradeClassDisplay[$upgradeClass] ?? null
                            )
                        ]
                    ]
                ]
            ];
        }
        return [
            "location"=> Fhir::reference('Location',$location->ihs_number,$location->name ?? null),
            "period"=> !empty($item['start']) ? Fhir::period($item['start'], $item['end'] ?? null) : null,
            "extension"=> $extension
        ];
    }

    private static function extensions($data)
    {
        $extensions = [];
        $codes = [
            'toFacility' => 'EncounterToFacility',
            'toSpecialty' => 'EncounterToSpecialty',
            'toEpisode' => 'EncounterToEpisode'
        ];
        foreach ($codes as $key => $name) {
            if (!empty($data[$key])) {
                $extensions[] = [
                    "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/".$name,
                    "valueCode"=> $data[$key]
                ];
            }
        }
        if (!empty($data['healthcareService'])) {
            $extensions[] = [
                "url"=> "https://fhir.kemkes.go.id/r4/StructureDefinition/HealthcareService",
                "valueReference"=> Fhir::reference('HealthcareService',$data['healthcareService'])
            ];
        }
        return $extensions;
    }

    private static function diagnosis($dataDiagnosis)
    {
        $roles = [
            'AD' => 'Admission diagnosis',
            'DD' => 'Discharge diagnosis',
            'CC' => 'Chief Complaint',
            'CM' => 'Comorbidity diagnosis',
            'pre-op' => 'pre-op diagnosis',
            'post-op' => 'post-op diagnosis',
            'billing' => 'Billing'
        ];
        $diagnosis = [];
        foreach ($dataDiagnosis as $item) {
            $use = $item['use'] ?? 'DD';
            $diagnosis[] = [
                "condition"=> Fhir::reference('Condition',$item['ihs_number'],$item['code_name'] ?? null),
                "use"=> Fhir::concept("http://terminology.hl7.org/CodeSystem/diagnosis-role",$use,$roles[$use] ?? null),
                // Keluhan utama (CC) di Postman tidak memakai rank
                "rank"=> isset($item['rank']) && $use != 'CC' ? intval($item['rank']) : null
            ];
        }
        return $diagnosis;
    }

    private static function hospitalization($data)
    {
        if (empty($data['dischargeDisposition'])) {
            return null;
        }
        $disposition = $data['dischargeDisposition'];
        return [
            "dischargeDisposition"=> Fhir::concept(
                "http://terminology.hl7.org/CodeSystem/discharge-disposition",
                $disposition[0],
                $disposition[1] ?? null,
                $disposition[2] ?? null
            )
        ];
    }
}
