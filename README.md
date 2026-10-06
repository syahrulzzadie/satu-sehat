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
