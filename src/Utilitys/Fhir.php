<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

/**
 * Helper tipe data FHIR yang dipakai berulang di payload Postman SATUSEHAT
 * (Reference, Coding, CodeableConcept, Quantity, Identifier, dst).
 *
 * Objek $encounter mengikuti konvensi library: ihs_number, no_rawat, period_start,
 * patient (ihs_number, name), practitioner (ihs_number, name), location (ihs_number, name).
 */
class Fhir
{
    const SNOMED = 'http://snomed.info/sct';
    const LOINC = 'http://loinc.org';
    const ICD10 = 'http://hl7.org/fhir/sid/icd-10';
    const ICD9CM = 'http://hl7.org/fhir/sid/icd-9-cm';
    const UCUM = 'http://unitsofmeasure.org';
    const KFA = 'http://sys-ids.kemkes.go.id/kfa';

    public static function reference($resourceType, $id, $display = null)
    {
        return self::clean([
            'reference' => $resourceType.'/'.$id,
            'display' => $display
        ]);
    }

    public static function patient($encounter)
    {
        return self::reference('Patient', $encounter->patient->ihs_number, $encounter->patient->name ?? null);
    }

    public static function practitioner($practitioner)
    {
        return self::reference('Practitioner', $practitioner->ihs_number, $practitioner->name ?? null);
    }

    public static function encounter($encounter, $display = null)
    {
        return self::reference('Encounter', $encounter->ihs_number, $display);
    }

    public static function organization($display = null)
    {
        return self::reference('Organization', Enviroment::organizationId(), $display);
    }

    public static function coding($system, $code, $display = null)
    {
        return self::clean([
            'system' => $system,
            'code' => $code,
            'display' => $display
        ]);
    }

    /**
     * CodeableConcept dengan satu coding. $text opsional.
     */
    public static function concept($system, $code, $display = null, $text = null)
    {
        return self::clean([
            'coding' => [self::coding($system, $code, $display)],
            'text' => $text
        ]);
    }

    /**
     * CodeableConcept dengan beberapa coding: [[system, code, display], ...].
     */
    public static function concepts(array $codings, $text = null)
    {
        $items = [];
        foreach ($codings as $c) {
            $items[] = self::coding($c[0], $c[1], $c[2] ?? null);
        }
        return self::clean([
            'coding' => $items,
            'text' => $text
        ]);
    }

    public static function quantity($value, $unit, $code = null, $system = self::UCUM)
    {
        return self::clean([
            'value' => is_numeric($value) ? $value + 0 : $value,
            'unit' => $unit,
            'system' => $system,
            'code' => $code ?? $unit
        ]);
    }

    /**
     * Identifier lokal fasyankes: http://sys-ids.kemkes.go.id/{type}/{organization_id}
     */
    public static function identifier($type, $value, $use = null)
    {
        return self::clean([
            'use' => $use,
            'system' => 'http://sys-ids.kemkes.go.id/'.$type.'/'.Enviroment::organizationId(),
            'value' => $value
        ]);
    }

    public static function dateTime($dateTime = null)
    {
        return $dateTime ? DateTimeFormat::parse($dateTime) : DateTimeFormat::now();
    }

    public static function period($start, $end = null)
    {
        return self::clean([
            'start' => self::dateTime($start),
            'end' => $end ? self::dateTime($end) : null
        ]);
    }

    public static function annotation($text)
    {
        return ['text' => $text];
    }

    /**
     * Narrative untuk section Composition.
     */
    public static function narrative($text)
    {
        return [
            'status' => 'additional',
            'div' => $text
        ];
    }

    /**
     * Buang nilai null / array kosong secara rekursif supaya payload bersih
     * (SATUSEHAT menolak field berisi null).
     */
    public static function clean($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        $isList = $data === [] || array_keys($data) === range(0, count($data) - 1);
        $result = [];
        foreach ($data as $key => $value) {
            $value = self::clean($value);
            // false / 0 tetap dipertahankan (mis. valueBoolean false)
            if ($value === null || $value === [] || $value === '') {
                continue;
            }
            $result[$key] = $value;
        }
        return $isList ? array_values($result) : $result;
    }
}
