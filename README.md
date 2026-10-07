# Satu Sehat KemenKes
Library Satu Sehat for PHP Laravel v8+

# Bridging List
* Organization
* Location
* Practitioner
* Patient
* Kyc
* Encounter
* Observation (TTV)
* Condition
* Composition
* Procedure
* MedicationRequest
* Medication
* MedicationDispense
* ServiceRequest (Rujuk Internal, Laboratorium, Radiologi)
* Observation Hasil Laboratorium & Radiologi
* Specimen (Laboratorium)
* DiagnosticReport (Laboratorium & Radiologi)
* SSRME (SHLink)
* Semua resource di Postman **SATUSEHAT PUBLIC** (51 resource FHIR, lihat [Mengikuti Postman SATUSEHAT PUBLIC](#mengikuti-postman-satusehat-public))
* Bundle transaction, JSON Patch, Master Data Wilayah/Sarana, KFA (harga JKN & Alkes v3), KPTL, Status Data Kelahiran

# Resource Wajib Satu Sehat (Penilaian Kelengkapan & Konsistensi)
| No | Resource | Method |
|----|----------|--------|
| 1 | Kunjungan (Encounter) | `createEncounter(..., $classCode)` AMB / EMER / IMP |
| 2 | Diagnosis (Condition) | `createCondition` |
| 3 | Observation | `createObservation` (TTV), `createObservationLab`, `createObservationRadiologi` |
| 4 | Tindakan (Procedure) | `createProcedure` |
| 5 | Peresepan (MedicationRequest) | `createMedicationRequest(..., $category)` |
| 6 | Obat diambil (MedicationDispense) | `createMedicationDispense` |
| 7 | Service Request | `createServiceRequest`, `createServiceRequestRadiologi` |
| 8 | Specimen Lab | `createSpecimen` |
| 9 | Radiologi (ImagingStudy) | dikirim dari aplikasi (DICOM dari RIS) |
| 10 | Diagnostic Report | `createDiagnosticReportLab`, `createDiagnosticReportRadiologi` |

> Token Satu Sehat disimpan di Cache Laravel (bukan session) sehingga aman dipakai dari route API / scheduler / n8n.

> NOTE: Beberapa masih belum sempurna, maka akan terus di update secara berkala. Terimakasih. 

# Mengikuti Postman SATUSEHAT PUBLIC
Acuan: workspace Postman [SATUSEHAT PUBLIC](https://www.postman.com/satusehat/satusehat-public/overview) (collection 00 s.d. 53, Master Data, KPTL).

## Builder resource (`createClinicalResource` / `create{Resource}`)
Body Postman dipindahkan apa adanya ke array `$data`. Bagian standar diisi otomatis dari objek `$encounter`
(`ihs_number`, `no_rawat`, `period_start`, `patient`, `practitioner`, `location`):
subject/patient, encounter/context, nakes (performer/recorder/requester/author/...), tanggal, status default,
Organization fasyankes (custodian/owner/provider/...).

Shortcut di `$data`:
* `datetime` waktu kejadian (`Y-m-d H:i:s`), default `period_start` encounter
* `identifier` string -> `http://sys-ids.kemkes.go.id/{tipe}/{org_id}`
* `category` string untuk Observation (`vital-signs`, `exam`, `survey`, `laboratory`, ...) & Condition (`chief-complaint`, `previous-condition`, `problem-list-item`, `encounter-diagnosis`)
* `note` string

```php
use syahrulzzadie\SatuSehat\SatuSehatCore as SS;
use syahrulzzadie\SatuSehat\Utilitys\Fhir;

// Postman 01 Rawat Jalan > 03. Anamnesis > Keluhan Utama
SS::createClinicalResource('Condition', $encounter, [
    'category' => 'chief-complaint',
    'code' => Fhir::concept(Fhir::SNOMED, '274640006', 'Fever with chills'),
    'note' => 'Demam menggigil sejak 2 hari yll'
]);

// Postman 01 Rawat Jalan > 04. Pemeriksaan Fisik > Kepala
SS::createClinicalResource('Observation', $encounter, [
    'category' => 'exam',
    'code' => Fhir::concept(Fhir::LOINC, '10199-8', 'Physical findings of Head Narrative'),
    'valueString' => 'Bentuk kepala simetris'
]);

// Resource tanpa method khusus memakai create{Resource}($encounter, $data, $practitioner = null)
SS::createAllergyIntolerance($encounter, [
    'identifier' => '202401123456',
    'category' => ['food'],
    'code' => Fhir::concept(Fhir::SNOMED, '226963000', 'Duck - meat', 'Alergi daging bebek')
]);
SS::createImmunization($encounter, [...]);
SS::createEpisodeOfCare($encounter, [...]);
SS::updateGoal($ihsGoal, $encounter, [...]);
```

Resource yang didukung builder: Account, AllergyIntolerance, BillingStatus, CarePlan, ChargeItem, ChargeItemResponse,
Claim, ClaimResponse, ClinicalImpression, Communication, CommunicationRequest, Composition, Condition, Consent, Coverage,
CoverageEligibilityRequest, CoverageEligibilityResponse, Device, DeviceDispense, DeviceRequest, DeviceUseStatement,
DiagnosticReport, DocumentReference, EpisodeOfCare, FamilyMemberHistory, Goal, Immunization, Invoice, Location,
Medication, MedicationAdministration, MedicationDispense, MedicationRequest, MedicationStatement, NutritionOrder,
Observation, Organization, Patient, PaymentNotice, PaymentReconciliation, Procedure, Provenance, QuestionnaireResponse,
RelatedPerson, RiskAssessment, ServiceRequest, Specimen, SupplyDelivery, SupplyRequest, Task, VisionPrescription.

## FHIR generik
| Method | Postman |
|--------|---------|
| `createResource($type, $body)` | `POST {{base_url}}/{Resource}` |
| `updateResource($type, $id, $body)` | `PUT {{base_url}}/{Resource}/:id` |
| `patchResource($type, $id, $operations)` | `PATCH {{base_url}}/{Resource}/:id` (JSON Patch) |
| `getResource($type, $id)` | `GET {{base_url}}/{Resource}/:id` |
| `searchResource($type, $params)` | `GET {{base_url}}/{Resource}?...` (termasuk hasil `_include`) |
| `sendBundle($entries)` | `POST {{base_url}}` Bundle transaction (`JsonData\Bundle::uuid()` / `Bundle::reference()` untuk urn:uuid) |

## Encounter
| Alur | Method |
|------|--------|
| Rawat jalan: kunjungan baru (arrived) | `createEncounter(..., $classCode, $options)` |
| Masuk ruang periksa (in-progress) | `inProgressEncounter($encounter, $waktuMasuk, $hospitalName, $classCode, $options)` |
| Pulang (finished + diagnosis + cara pulang) | `finishEncounter($encounter, $diagnosa, $waktuMasuk, $waktuPulang, $hospitalName, $classCode, $options)` |
| Rawat inap / IGD: menunggu ruang, pindah ruang, titip rawat, ganti DPJP, rawat bersama, ICU | `saveEncounter($data)` (POST bila belum ada `ihs_number`, PUT bila ada) |

`$options`: `serviceType`, `serviceClass` (`reguler`, `1`, `2`, `3`, `vip`), `upgradeClass` (`kelas-tetap`, `naik-kelas`, `turun-kelas`, `titip-rawat`),
`toFacility`/`toSpecialty`/`toEpisode` (`new`/`returning`), `healthcareService`, `episodeOfCare`, `basedOn`, `dischargeDisposition` (`['home', 'Home', 'teks']`).

```php
// Postman 02 Rawat Inap > Variasi H. Perpindahan Ruangan ke ICU
SS::saveEncounter([
    'ihs_number' => $ihsEncounter, 'no_rawat' => $noRawat, 'class' => 'IMP', 'status' => 'in-progress',
    'patient' => $patient, 'period' => ['2021-09-10 15:00:00'], 'basedOn' => $ihsSuratPerintahRanap,
    'statusHistory' => [['in-progress', '2021-09-10 15:00:00']],
    'locations' => [
        ['location' => $bed2, 'start' => '2021-09-10 15:00:00', 'end' => '2021-09-11 15:00:00', 'serviceClass' => '1'],
        ['location' => $bedIcu, 'start' => '2021-09-11 15:00:00', 'serviceClass' => '1']
    ],
    'participants' => [['practitioner' => $dpjp]],  // type ATND default, SPRF untuk rawat bersama
    'hospitalName' => 'RS ...'
]);
```

## Per collection Postman
| Collection | Method khusus |
|------------|---------------|
| 01 Rawat Jalan | Encounter di atas, builder resource, `searchImagingStudyByAcsn`, `patchResource('ClinicalImpression', ...)` |
| 02 Rawat Inap / 03 IGD | `saveEncounter`, `createLocationData` (bangsal/ruang/bed), `updateBedStatus($bed, 'O'/'U', $pathSudahAda)`, `createPatient` (NIK / `nik-ibu` bayi baru lahir) |
| 04 Farmasi | `createDocumentReference`, `searchResepNasional`, `searchMedicationRequestByResepNasional` |
| 06-24, 31-53 Use Case | builder resource + `createEpisodeOfCare`, `changeEpisodeOfCareStatus($id, 'active'/'finished', $waktu)`, `createImmunization`, `createRelatedPerson`, `createVisionPrescription` |
| 25-26 Modul Klaim | `createAccount`, `createChargeItem`, `createCoverage`, `createCoverageEligibilityRequest`, `createClaim`, `createInvoice`, `createPaymentNotice`, ... |
| 30 Rujukan | `createTask`, `createClinicalResource('ServiceRequest', ...)` |
| 49 Data Kelahiran | `getStatusDataKelahiran`, `deleteDataKelahiran` |
| 51 TTE | `createConsent`, `createProvenance`, `createTask` |
| Master Data APIGEE | `getMasterWilayah('provinces', [...], 'v1')`, `getMasterSarana`, `getKfaPriceJkn`, `searchKfaAlkes` |
| Master Data KPTL | `searchKptl($endpoint, $body)`; isi `Constant::$kptlUrl` dulu (host tidak tercantum di Postman publik) |
| 01 Mencari Pasien & Nakes | `getPatientById`, `searchPatient`, `getPractitionerById`, `searchPractitioner` |

Tidak dicakup library: request `{{webhook_url}}` (contoh payload yang *diterima* server fasyankes), `{{privateHost}}` (DICOM Router lokal), dan SSRME v2 `ntl` yang hanya tersedia di staging (library tetap memakai `ssrme/v1/hf/shl` produksi).

## Perubahan perilaku (mengikuti Postman)
* `createEncounter` kini `statusHistory` = `[arrived]` saja (sebelumnya langsung berisi `finished`), `period.end` tidak dikirim, `location.period` ikut dikirim.
* `updateEncounterCondition` mengirim riwayat `arrived -> in-progress -> finished` beserta `length` (menit).
* `cancelEncounter` mengirim riwayat `arrived -> cancelled`.
* `createCondition` menambah `onsetDateTime` & `recordedDate`.
* `createProcedure` memakai kategori `http://terminology.kemkes.go.id|TK000028` (sebelumnya SNOMED 103693007).
* `createMedication` menambah `meta.profile`; `createMedicationDispense` menambah `whenPrepared` & `whenHandedOver`.
