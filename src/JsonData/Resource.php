<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Fhir;

/**
 * Builder generik resource klinis berdasarkan pola Postman SATUSEHAT PUBLIC.
 *
 * Builder mengisi bagian standar (subject/patient, encounter/context, tenaga kesehatan,
 * tanggal, status default, identifier) dari objek $encounter, lalu menimpanya dengan
 * field FHIR pada $data yang bentuknya sama persis dengan body Postman.
 *
 * Shortcut pada $data:
 * - 'datetime'   : waktu kejadian (Y-m-d H:i:s), diisikan ke semua field tanggal standar resource.
 *                  Default period_start encounter.
 * - 'identifier' : string nomor lokal -> identifier http://sys-ids.kemkes.go.id/{tipe}/{org_id}
 * - 'category'   : string kode untuk Observation / Condition (lihat Resource::category()).
 * - 'note'       : string -> [['text' => ...]]
 */
class Resource
{
    /**
     * subject  : nama field pasien (null = tidak ada), akhiran :list untuk array reference
     * encounter: nama field kunjungan (null = tidak ada)
     * actor    : [field, bentuk] bentuk: ref | list | actor (performer[].actor) | immunization (performer AP)
     * dates    : field yang diisi dari 'datetime' (period = start/end, start = start saja, date = Y-m-d,
     *            history = statusHistory [status, start])
     * id       : tipe identifier sys-ids (idUse: nilai identifier.use bila Postman memakainya)
     * org      : field (atau daftar field) yang diisi Organization fasyankes (Enviroment::organizationId)
     */
    private static $maps = [
        'Account' => [
            'subject' => 'subject:list', 'org' => 'owner', 'defaults' => ['status' => 'active']
        ],
        'AllergyIntolerance' => [
            'subject' => 'patient', 'encounter' => 'encounter', 'actor' => ['recorder', 'ref'],
            'dates' => ['recordedDate'], 'id' => 'allergy', 'idUse' => 'official',
            'defaults' => [
                'clinicalStatus' => ['http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical', 'active', 'Active'],
                'verificationStatus' => ['http://terminology.hl7.org/CodeSystem/allergyintolerance-verification', 'confirmed', 'Confirmed']
            ]
        ],
        'CarePlan' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['author', 'ref'],
            'dates' => ['created'], 'defaults' => ['status' => 'active', 'intent' => 'plan']
        ],
        'ChargeItem' => [
            'subject' => 'subject', 'encounter' => 'context', 'actor' => ['performer', 'actor'],
            'defaults' => ['status' => 'billable']
        ],
        'ChargeItemResponse' => [
            'subject' => 'subject', 'encounter' => 'encounter'
        ],
        'Claim' => [
            'subject' => 'patient', 'actor' => ['enterer', 'ref'], 'dates' => ['created'], 'org' => 'provider',
            'defaults' => ['status' => 'active', 'use' => 'claim']
        ],
        'ClaimResponse' => [
            'subject' => 'patient', 'dates' => ['created'], 'org' => 'requestor',
            'defaults' => ['status' => 'active', 'use' => 'claim']
        ],
        'ClinicalImpression' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['assessor', 'ref'],
            'dates' => ['effectiveDateTime', 'date'], 'defaults' => ['status' => 'completed']
        ],
        'Composition' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['author', 'list'],
            'dates' => ['date'], 'id' => 'composition', 'org' => 'custodian', 'defaults' => ['status' => 'final']
        ],
        'Communication' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'dates' => ['sent'], 'org' => 'sender',
            'defaults' => ['status' => 'completed']
        ],
        'CommunicationRequest' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'dates' => ['authoredOn'], 'org' => 'sender',
            'defaults' => ['status' => 'active']
        ],
        'Condition' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['recorder', 'ref'],
            'dates' => ['recordedDate'],
            'defaults' => [
                'clinicalStatus' => ['http://terminology.hl7.org/CodeSystem/condition-clinical', 'active', 'Active']
            ]
        ],
        'Consent' => [
            'subject' => 'patient', 'dates' => ['dateTime'], 'org' => 'organization:list',
            'defaults' => ['status' => 'active']
        ],
        'Coverage' => [
            'subject' => 'beneficiary', 'defaults' => ['status' => 'active']
        ],
        'CoverageEligibilityRequest' => [
            'subject' => 'patient', 'actor' => ['enterer', 'ref'], 'dates' => ['created'], 'org' => 'provider',
            'defaults' => ['status' => 'active']
        ],
        'CoverageEligibilityResponse' => [
            'subject' => 'patient', 'dates' => ['created'], 'org' => 'requestor',
            'defaults' => ['status' => 'active']
        ],
        'Device' => [
            'id' => 'device', 'org' => 'owner', 'defaults' => ['status' => 'active']
        ],
        'DeviceDispense' => [
            'subject' => 'subject', 'actor' => ['performer', 'actor'],
            'dates' => ['whenPrepared', 'whenHandedOver'], 'id' => 'devicedispense', 'defaults' => ['status' => 'completed']
        ],
        'DeviceRequest' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['requester', 'ref'],
            'dates' => ['authoredOn'], 'id' => 'devicerequest',
            'defaults' => ['status' => 'active', 'intent' => 'order', 'priority' => 'routine']
        ],
        'DeviceUseStatement' => [
            'subject' => 'subject', 'actor' => ['source', 'ref'],
            'dates' => ['recordedOn'], 'id' => 'deviceusestatement', 'defaults' => ['status' => 'active']
        ],
        'DiagnosticReport' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['performer', 'list'],
            'dates' => ['effectiveDateTime', 'issued'], 'defaults' => ['status' => 'final']
        ],
        'DocumentReference' => [
            'subject' => 'subject', 'encounter' => 'context.encounter', 'actor' => ['author', 'list'],
            'dates' => ['date'], 'id' => 'prescription', 'idUse' => 'official', 'org' => 'custodian',
            'defaults' => ['status' => 'current', 'docStatus' => 'final']
        ],
        'EpisodeOfCare' => [
            'subject' => 'patient', 'dates' => ['period:start', 'statusHistory:history'],
            'id' => 'episode-of-care', 'org' => 'managingOrganization', 'defaults' => ['status' => 'active']
        ],
        'FamilyMemberHistory' => [
            'subject' => 'patient', 'dates' => ['date'], 'defaults' => ['status' => 'completed']
        ],
        'Goal' => [
            'subject' => 'subject', 'actor' => ['expressedBy', 'ref'],
            'dates' => ['statusDate:date'], 'defaults' => ['lifecycleStatus' => 'planned']
        ],
        'Immunization' => [
            'subject' => 'patient', 'encounter' => 'encounter', 'actor' => ['performer', 'immunization'],
            'dates' => ['occurrenceDateTime', 'recorded'],
            'defaults' => ['status' => 'completed', 'primarySource' => true]
        ],
        'Invoice' => [
            'subject' => 'subject', 'dates' => ['date'], 'org' => 'issuer', 'defaults' => ['status' => 'issued']
        ],
        'Location' => [
            'id' => 'location', 'org' => 'managingOrganization',
            'defaults' => ['status' => 'active', 'mode' => 'instance']
        ],
        'Medication' => [
            'id' => 'medication', 'idUse' => 'official',
            'defaults' => [
                'status' => 'active',
                'meta' => ['profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Medication']]
            ]
        ],
        'MedicationAdministration' => [
            'subject' => 'subject', 'encounter' => 'context', 'actor' => ['performer', 'actor'],
            'dates' => ['effectivePeriod:period'], 'defaults' => ['status' => 'completed']
        ],
        'MedicationDispense' => [
            'subject' => 'subject', 'encounter' => 'context', 'actor' => ['performer', 'actor'],
            'dates' => ['whenPrepared', 'whenHandedOver'], 'id' => 'prescription', 'idUse' => 'official', 'defaults' => ['status' => 'completed']
        ],
        'MedicationRequest' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['requester', 'ref'],
            'dates' => ['authoredOn'], 'id' => 'prescription', 'idUse' => 'official',
            'defaults' => ['status' => 'completed', 'intent' => 'order', 'priority' => 'routine']
        ],
        'MedicationStatement' => [
            'subject' => 'subject', 'encounter' => 'context', 'dates' => ['dateAsserted'],
            'defaults' => ['status' => 'completed']
        ],
        'NutritionOrder' => [
            'subject' => 'patient', 'encounter' => 'encounter', 'actor' => ['orderer', 'ref'],
            'dates' => ['dateTime'], 'defaults' => ['status' => 'active', 'intent' => 'proposal']
        ],
        'Observation' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['performer', 'list'],
            'dates' => ['effectiveDateTime', 'issued'], 'id' => 'observation', 'defaults' => ['status' => 'final']
        ],
        'Organization' => [
            'id' => 'organization', 'idUse' => 'official', 'org' => 'partOf',
            'defaults' => ['active' => true]
        ],
        'Patient' => [
            'defaults' => [
                'active' => true,
                'meta' => ['profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Patient']]
            ]
        ],
        'PaymentNotice' => [
            'dates' => ['created'], 'org' => 'provider', 'defaults' => ['status' => 'active']
        ],
        'PaymentReconciliation' => [
            'dates' => ['created'], 'org' => 'requestor', 'defaults' => ['status' => 'active']
        ],
        'Procedure' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['performer', 'actor'],
            'dates' => ['performedPeriod:period'], 'defaults' => ['status' => 'completed']
        ],
        'Provenance' => [
            'dates' => ['recorded']
        ],
        'QuestionnaireResponse' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['author', 'ref'],
            'dates' => ['authored'], 'defaults' => ['status' => 'completed']
        ],
        'RelatedPerson' => [
            'subject' => 'patient', 'defaults' => ['active' => true]
        ],
        'RiskAssessment' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['performer', 'ref'],
            'defaults' => ['status' => 'final']
        ],
        'ServiceRequest' => [
            'subject' => 'subject', 'encounter' => 'encounter', 'actor' => ['requester', 'ref'],
            'dates' => ['occurrenceDateTime', 'authoredOn'], 'id' => 'servicerequest',
            'defaults' => ['status' => 'active', 'intent' => 'original-order', 'priority' => 'routine']
        ],
        'Specimen' => [
            'subject' => 'subject', 'dates' => ['receivedTime'], 'id' => 'specimen',
            'defaults' => ['status' => 'available']
        ],
        'Task' => [
            'encounter' => 'encounter', 'dates' => ['authoredOn', 'lastModified'], 'id' => 'task',
            'org' => ['requester', 'owner'], 'defaults' => ['status' => 'requested', 'intent' => 'order', 'priority' => 'routine']
        ],
        'VisionPrescription' => [
            'subject' => 'patient', 'encounter' => 'encounter', 'actor' => ['prescriber', 'ref'],
            'dates' => ['created', 'dateWritten'], 'defaults' => ['status' => 'active']
        ],
        'BillingStatus' => [
            'subject' => 'subject', 'defaults' => ['status' => 'final']
        ],
        'SupplyDelivery' => [
            'dates' => ['occurrenceDateTime'], 'id' => 'supplydelivery', 'defaults' => ['status' => 'completed']
        ],
        'SupplyRequest' => [
            'dates' => ['authoredOn'], 'id' => 'supplyrequest', 'defaults' => ['status' => 'active']
        ]
    ];

    /**
     * Kode kategori yang sistemnya bukan HL7 (terminology.kemkes.go.id).
     */
    private static $kemkesConditionCategory = [
        'chief-complaint' => 'Chief Complaint',
        'previous-condition' => 'Previous Condition'
    ];

    private static $hl7Category = [
        'Observation' => [
            'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
            'display' => [
                'social-history' => 'Social History', 'vital-signs' => 'Vital Signs', 'imaging' => 'Imaging',
                'laboratory' => 'Laboratory', 'procedure' => 'Procedure', 'survey' => 'Survey',
                'exam' => 'Exam', 'therapy' => 'Therapy', 'activity' => 'Activity'
            ]
        ],
        'Condition' => [
            'system' => 'http://terminology.hl7.org/CodeSystem/condition-category',
            'display' => [
                'problem-list-item' => 'Problem List Item', 'encounter-diagnosis' => 'Encounter Diagnosis'
            ]
        ]
    ];

    public static function supports($resourceType)
    {
        return isset(self::$maps[$resourceType]);
    }

    /**
     * @param string $resourceType mis. 'AllergyIntolerance'
     * @param object|null $encounter objek encounter library (boleh null untuk Device/Medication/Supply*)
     * @param array $data field FHIR sesuai Postman (+ shortcut, lihat docblock kelas)
     * @param object|null $practitioner default $encounter->practitioner
     */
    public static function formData($resourceType, $encounter, array $data, $practitioner = null)
    {
        $map = self::$maps[$resourceType] ?? [];
        $form = ['resourceType' => $resourceType];

        foreach ($map['defaults'] ?? [] as $field => $value) {
            // [system, code, display] -> CodeableConcept
            $form[$field] = (is_array($value) && isset($value[0]) && count($value) == 3)
                ? Fhir::concept($value[0], $value[1], $value[2])
                : $value;
        }

        if (!empty($map['id']) && isset($data['identifier']) && is_string($data['identifier'])) {
            $data['identifier'] = [Fhir::identifier($map['id'], $data['identifier'], $map['idUse'] ?? null)];
        }

        if ($encounter) {
            if (!empty($map['subject'])) {
                $parts = explode(':', $map['subject']);
                $form[$parts[0]] = isset($parts[1]) ? [Fhir::patient($encounter)] : Fhir::patient($encounter);
            }
            if (isset($map['encounter']) && $map['encounter'] == 'context.encounter') {
                // DocumentReference: encounter ada di context.encounter[] bersama context.related
                $data['context'] = ($data['context'] ?? []) + ['encounter' => [Fhir::encounter($encounter)]];
            } else if (!empty($map['encounter'])) {
                $form[$map['encounter']] = Fhir::encounter($encounter);
            }
        }

        foreach ((array) ($map['org'] ?? []) as $field) {
            $parts = explode(':', $field);
            $form[$parts[0]] = isset($parts[1]) ? [Fhir::organization()] : Fhir::organization();
        }

        $practitioner = $practitioner ?? ($encounter->practitioner ?? null);
        if ($practitioner && !empty($map['actor'])) {
            list($field, $shape) = $map['actor'];
            $ref = Fhir::practitioner($practitioner);
            if ($shape == 'list') {
                $form[$field] = [$ref];
            } else if ($shape == 'immunization') {
                $form[$field] = [[
                    'function' => Fhir::concept('http://terminology.hl7.org/CodeSystem/v2-0443', 'AP', 'Administering Provider'),
                    'actor' => $ref
                ]];
            } else if ($shape == 'actor') {
                $form[$field] = [['actor' => $ref]];
            } else {
                $form[$field] = $ref;
            }
        }

        $datetime = $data['datetime'] ?? ($encounter->period_start ?? null);
        unset($data['datetime']);
        foreach ($map['dates'] ?? [] as $field) {
            $parts = explode(':', $field);
            $type = $parts[1] ?? 'dateTime';
            if ($type == 'period') {
                $form[$parts[0]] = Fhir::period($datetime, $datetime);
            } else if ($type == 'start') {
                $form[$parts[0]] = Fhir::period($datetime);
            } else if ($type == 'history') {
                $form[$parts[0]] = [[
                    'status' => $data['status'] ?? ($form['status'] ?? null),
                    'period' => Fhir::period($datetime)
                ]];
            } else if ($type == 'date') {
                $form[$parts[0]] = date('Y-m-d', $datetime ? strtotime($datetime) : time());
            } else {
                $form[$parts[0]] = Fhir::dateTime($datetime);
            }
        }

        if (isset($data['category']) && is_string($data['category']) && isset(self::$hl7Category[$resourceType])) {
            $data['category'] = [self::category($resourceType, $data['category'])];
        }
        if (isset($data['note']) && is_string($data['note'])) {
            $data['note'] = [Fhir::annotation($data['note'])];
        }

        return Fhir::clean(array_replace($form, $data));
    }

    /**
     * Kategori Observation (vital-signs, exam, survey, laboratory, imaging, ...) dan
     * Condition (chief-complaint, previous-condition, problem-list-item, encounter-diagnosis).
     */
    public static function category($resourceType, $code)
    {
        if ($resourceType == 'Condition' && isset(self::$kemkesConditionCategory[$code])) {
            return Fhir::concept('http://terminology.kemkes.go.id', $code, self::$kemkesConditionCategory[$code]);
        }
        $hl7 = self::$hl7Category[$resourceType] ?? null;
        if (!$hl7) {
            return ['text' => $code];
        }
        return Fhir::concept($hl7['system'], $code, $hl7['display'][$code] ?? null);
    }
}
