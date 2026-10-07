<?php

namespace syahrulzzadie\SatuSehat;

use syahrulzzadie\SatuSehat\JsonData as jsonData;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Utilitys\Constant;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\Fhir;
use syahrulzzadie\SatuSehat\Utilitys\HttpRequest;
use syahrulzzadie\SatuSehat\Utilitys\Security;
use syahrulzzadie\SatuSehat\Utilitys\Url;

/**
 * Resource tanpa method khusus (lihat __callStatic & JsonData\Resource).
 * $encounter boleh null untuk resource non-kunjungan (Device, Coverage, Account, dst).
 * @method static array createAccount($encounter, array $data, $practitioner = null)
 * @method static array updateAccount($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createAllergyIntolerance($encounter, array $data, $practitioner = null)
 * @method static array updateAllergyIntolerance($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createBillingStatus($encounter, array $data, $practitioner = null)
 * @method static array updateBillingStatus($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createCarePlan($encounter, array $data, $practitioner = null)
 * @method static array updateCarePlan($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createChargeItem($encounter, array $data, $practitioner = null)
 * @method static array updateChargeItem($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createChargeItemResponse($encounter, array $data, $practitioner = null)
 * @method static array updateChargeItemResponse($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createClaim($encounter, array $data, $practitioner = null)
 * @method static array updateClaim($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createClaimResponse($encounter, array $data, $practitioner = null)
 * @method static array updateClaimResponse($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createClinicalImpression($encounter, array $data, $practitioner = null)
 * @method static array updateClinicalImpression($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createCommunication($encounter, array $data, $practitioner = null)
 * @method static array updateCommunication($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createCommunicationRequest($encounter, array $data, $practitioner = null)
 * @method static array updateCommunicationRequest($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createConsent($encounter, array $data, $practitioner = null)
 * @method static array createCoverage($encounter, array $data, $practitioner = null)
 * @method static array updateCoverage($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createCoverageEligibilityRequest($encounter, array $data, $practitioner = null)
 * @method static array updateCoverageEligibilityRequest($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createCoverageEligibilityResponse($encounter, array $data, $practitioner = null)
 * @method static array updateCoverageEligibilityResponse($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDevice($encounter, array $data, $practitioner = null)
 * @method static array updateDevice($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDeviceDispense($encounter, array $data, $practitioner = null)
 * @method static array updateDeviceDispense($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDeviceRequest($encounter, array $data, $practitioner = null)
 * @method static array updateDeviceRequest($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDeviceUseStatement($encounter, array $data, $practitioner = null)
 * @method static array updateDeviceUseStatement($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDiagnosticReport($encounter, array $data, $practitioner = null)
 * @method static array updateDiagnosticReport($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createDocumentReference($encounter, array $data, $practitioner = null)
 * @method static array updateDocumentReference($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createEpisodeOfCare($encounter, array $data, $practitioner = null)
 * @method static array updateEpisodeOfCare($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createFamilyMemberHistory($encounter, array $data, $practitioner = null)
 * @method static array updateFamilyMemberHistory($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createGoal($encounter, array $data, $practitioner = null)
 * @method static array updateGoal($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createImmunization($encounter, array $data, $practitioner = null)
 * @method static array updateImmunization($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createInvoice($encounter, array $data, $practitioner = null)
 * @method static array updateInvoice($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createMedicationAdministration($encounter, array $data, $practitioner = null)
 * @method static array updateMedicationAdministration($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createMedicationStatement($encounter, array $data, $practitioner = null)
 * @method static array updateMedicationStatement($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createNutritionOrder($encounter, array $data, $practitioner = null)
 * @method static array updateNutritionOrder($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array updatePatient($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createPaymentNotice($encounter, array $data, $practitioner = null)
 * @method static array updatePaymentNotice($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createPaymentReconciliation($encounter, array $data, $practitioner = null)
 * @method static array updatePaymentReconciliation($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createProvenance($encounter, array $data, $practitioner = null)
 * @method static array updateProvenance($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createQuestionnaireResponse($encounter, array $data, $practitioner = null)
 * @method static array updateQuestionnaireResponse($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createRelatedPerson($encounter, array $data, $practitioner = null)
 * @method static array updateRelatedPerson($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createRiskAssessment($encounter, array $data, $practitioner = null)
 * @method static array updateRiskAssessment($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createSupplyDelivery($encounter, array $data, $practitioner = null)
 * @method static array updateSupplyDelivery($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createSupplyRequest($encounter, array $data, $practitioner = null)
 * @method static array updateSupplyRequest($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createTask($encounter, array $data, $practitioner = null)
 * @method static array updateTask($ihsNumber, $encounter, array $data, $practitioner = null)
 * @method static array createVisionPrescription($encounter, array $data, $practitioner = null)
 * @method static array updateVisionPrescription($ihsNumber, $encounter, array $data, $practitioner = null)
 */
class SatuSehatCore
{
    public static function getPatientByNik($nik)
    {
        $url = Url::patientUrl($nik);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Patient::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function getPractitionerByNik($nik)
    {
        $url = Url::practitionerUrl($nik);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Practitioner::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function showOrganization()
    {
        $url = Url::showOrganizationUrl();
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::show($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createOrganization($hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode)
    {
        $url = Url::createOrganizationUrl();
        $formData = jsonData\Organization::formCreateData($hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateOrganization($ihsNumber, $hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode)
    {
        $url = Url::updateOrganizationUrl($ihsNumber);
        $formData = jsonData\Organization::formUpdateData($ihsNumber, $hospitalName, $kode, $name, $type, $phone, $email, $site, $address, $city, $postCode);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Organization::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function showLocation($ihsNumberOrganization)
    {
        $url = Url::showLocationUrl($ihsNumberOrganization);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::show($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createLocation($organization,$kode,$name,$hospitalName,$phone,$email,$website,$address,$city,$postCode)
    {
        $url = Url::createLocationUrl();
        $formData = jsonData\Location::formCreateData($organization,$kode,$name,$hospitalName,$phone,$email,$website,$address,$city,$postCode);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateLocation($ihsNumber,$organization,$kode,$name,$hospitalName,$phone,$email,$website,$address,$city,$postCode)
    {
        $url = Url::updateLocationUrl($ihsNumber);
        $formData = jsonData\Location::formUpdateData($ihsNumber,$organization,$kode,$name,$hospitalName,$phone,$email,$website,$address,$city,$postCode);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Location::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateConsent($ihsNumber,$petugas,$status)
    {
        $url = Url::updateConsentPatientUrl();
        $formData = jsonData\Consent::formData($ihsNumber,$petugas,$status);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Consent::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * @param string $classCode AMB (rawat jalan), EMER (IGD), IMP (rawat inap)
     * @param array $options lihat JsonData\Encounter (serviceType, serviceClass, toFacility, healthcareService, dst)
     */
    public static function createEncounter($noRawat,$date,$time,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::createEncounterUrl();
        $formData = jsonData\Encounter::formCreateData($noRawat,$date,$time,$patient,$practitioner,$location,$hospitalName,$classCode,$options);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounter($encounter,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formUpdateData($encounter,$patient,$practitioner,$location,$hospitalName,$classCode,$options);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Encounter fleksibel untuk semua variasi Postman (rawat inap pindah ruang, titip rawat,
     * ganti DPJP, rawat bersama, menunggu ruang, IGD). POST bila belum ada ihs_number, PUT bila ada.
     * Struktur $data lihat JsonData\Encounter::formData().
     */
    public static function saveEncounter(array $data)
    {
        $formData = jsonData\Encounter::formData($data);
        if (empty($data['ihs_number'])) {
            $http = HttpRequest::post(Url::createEncounterUrl(),$formData);
        } else {
            $http = HttpRequest::put(Url::updateEncounterUrl($data['ihs_number']),$formData);
        }
        if ($http['status']) {
            return jsonResponse\Encounter::convert($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Pasien masuk ruang pemeriksaan: status arrived -> in-progress.
     */
    public static function inProgressEncounter($encounter,$inProgressDateTime,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formInProgressData($encounter,$inProgressDateTime,$hospitalName,$classCode,$options);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Kunjungan selesai: status finished + diagnosis + cara pulang ($options['dischargeDisposition']).
     * $dataDiagnosa: [['ihs_number' => ..., 'code_name' => ..., 'rank' => 1, 'use' => 'DD'], ['ihs_number' => ..., 'use' => 'CC']]
     */
    public static function finishEncounter($encounter,$dataDiagnosa,$inProgressDateTime,$finishedDateTime,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formFinishedData($encounter,$dataDiagnosa,$inProgressDateTime,$finishedDateTime,$hospitalName,$classCode,$options);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function cancelEncounter($encounter,$patient,$practitioner,$location,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formCancelData($encounter,$patient,$practitioner,$location,$hospitalName,$classCode,$options);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateEncounterCondition($encounter,$dataDiagnosa,$hospitalName,$classCode = 'AMB',$options = [])
    {
        $url = Url::updateEncounterUrl($encounter->ihs_number);
        $formData = jsonData\Encounter::formUpdateCondition($encounter,$dataDiagnosa,$hospitalName,$classCode,$options);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyEncounter($ihsNumberPatient)
    {
        $url = Url::historyEncounterUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Encounter::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createCondition($encounter,$code,$name)
    {
        $url = Url::createConditionUrl();
        $formData = jsonData\Condition::formCreateData($encounter,$code,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateCondition($ihsNumber,$encounter,$code,$name)
    {
        $url = Url::updateConditionUrl($ihsNumber);
        $formData = jsonData\Condition::formUpdateData($ihsNumber,$encounter,$code,$name);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyCondition($ihsNumberPatient)
    {
        $url = Url::historyConditionUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Condition::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Observation TTV. effectiveDateTime wajib (RuleNumber 10295), default period_start encounter.
     */
    public static function createObservation($encounter,$practitioner,$name,$value,$effectiveDateTime = null)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateData($encounter,$practitioner,$name,$value,$effectiveDateTime);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateObservation($ihsNumber,$encounter,$practitioner,$name,$value,$effectiveDateTime = null)
    {
        $url = Url::updateObservationUrl($ihsNumber);
        $formData = jsonData\Observation::formUpdateData($ihsNumber,$encounter,$practitioner,$name,$value,$effectiveDateTime);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyObservation($ihsNumberPatient)
    {
        $url = Url::historyObservationUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createComposition($encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi)
    {
        $url = Url::createCompositionUrl();
        $formData = jsonData\Composition::formCreateData($encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateComposition($ihsNumber,$encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi)
    {
        $url = Url::updateCompositionUrl($ihsNumber);
        $formData = jsonData\Composition::formUpdateData($ihsNumber,$encounter,$noRawat,$subjective,$objective,$analisys,$planning,$instruksi);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyComposition($ihsNumberPatient)
    {
        $url = Url::historyCompositionUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Composition::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createProcedure($encounter, $procedureCode, $procedureName)
    {
        $url = Url::createProcedureUrl();
        $formData = jsonData\Procedure::formCreateData($encounter, $procedureCode, $procedureName);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateProcedure($ihsNumber, $encounter, $procedureCode, $procedureName)
    {
        $url = Url::updateProcedureUrl($ihsNumber);
        $formData = jsonData\Procedure::formUpdateData($ihsNumber, $encounter, $procedureCode, $procedureName);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyProcedure($ihsNumberPatient)
    {
        $url = Url::historyProcedureUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Procedure::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createMedication($noResep, $kodeObat, $namaObat)
    {
        $url = Url::createMedicationUrl();
        $formData = jsonData\Medication::formCreateData($noResep, $kodeObat, $namaObat);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Medication::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateMedication($ihsNumber,$noResep,$kodeObat,$namaObat)
    {
        $url = Url::updateMedicationUrl($ihsNumber);
        $formData = jsonData\Medication::formUpdateData($ihsNumber,$noResep,$kodeObat,$namaObat);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Medication::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * @param string $category outpatient | inpatient
     */
    public static function createMedicationRequest($encounter,$medication,$noRawat,$aturanPakai,$category = 'outpatient')
    {
        $url = Url::createMedicationRequestUrl();
        $formData = jsonData\MedicationRequest::formCreateData($encounter, $medication, $noRawat, $aturanPakai, $category);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateMedicationRequest($ihsNumber,$encounter,$medication,$noRawat,$aturanPakai,$category = 'outpatient')
    {
        $url = Url::updateMedicationRequestUrl($ihsNumber);
        $formData = jsonData\MedicationRequest::formUpdateData($ihsNumber, $encounter,$medication,$noRawat,$aturanPakai,$category);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyMedicationRequest($ihsNumberPatient)
    {
        $url = Url::historyMedicationRequestUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationRequest::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createMedicationDispense($encounter,$practitoner,$noRawat,$medicationRequest)
    {
        $url = Url::createMedicationDispenseUrl();
        $formData = jsonData\MedicationDispense::formCreateData($encounter,$practitoner,$noRawat,$medicationRequest);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationDispense::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateMedicationDispense($ihsNumber,$encounter,$practitoner,$noRawat,$medicationRequest)
    {
        $url = Url::updateMedicationDispenseUrl($ihsNumber);
        $formData = jsonData\MedicationDispense::formUpdateData($ihsNumber,$encounter,$practitoner,$noRawat,$medicationRequest);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationDispense::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyMedicationDispense($ihsNumberPatient)
    {
        $url = Url::historyMedicationDispenseUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\MedicationDispense::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createServiceRequest($noPermintaan,$encounter,$code,$name,$description)
    {
        $url = Url::createServiceRequestUrl();
        $formData = jsonData\ServiceRequest::formCreateData($noPermintaan,$encounter,$code,$name,$description);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateServiceRequest($ihsNumber,$noPermintaan,$encounter,$code,$name,$description)
    {
        $url = Url::updateServiceRequestUrl($ihsNumber);
        $formData = jsonData\ServiceRequest::formUpdateData($ihsNumber,$noPermintaan,$encounter,$code,$name,$description);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyServiceRequest($ihsNumberPatient)
    {
        $url = Url::historyServiceRequestUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createServiceRequestRadiologi($noPermintaan,$encounter,$code,$name,$description,$acsn)
    {
        $url = Url::createServiceRequestUrl();
        $formData = jsonData\ServiceRequest::formCreateDataRadiologi($noPermintaan,$encounter,$code,$name,$description,$acsn);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::convertRadiologi($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateServiceRequestRadiologi($ihsNumber,$noPermintaan,$encounter,$code,$name,$description,$acsn)
    {
        $url = Url::updateServiceRequestUrl($ihsNumber);
        $formData = jsonData\ServiceRequest::formUpdateDataRadiologi($ihsNumber,$noPermintaan,$encounter,$code,$name,$description,$acsn);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::convertRadiologi($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyServiceRequestRadiologi($ihsNumberPatient)
    {
        $url = Url::historyServiceRequestUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\ServiceRequest::historyRadiologi($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createObservationLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$value,$effectiveDateTime,$issuedDateTime);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convertResult($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createObservationRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime = null)
    {
        $url = Url::createObservationUrl();
        $formData = jsonData\Observation::formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$value,$effectiveDateTime,$issuedDateTime);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Observation::convertResult($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createSpecimen($noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime = null)
    {
        $url = Url::createSpecimenUrl();
        $formData = jsonData\Specimen::formCreateData($noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Specimen::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateSpecimen($ihsNumber,$noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime = null)
    {
        $url = Url::updateSpecimenUrl($ihsNumber);
        $formData = jsonData\Specimen::formUpdateData($ihsNumber,$noSpecimen,$encounter,$serviceRequestIhs,$specimenCode,$specimenName,$collectedDateTime,$receivedDateTime);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Specimen::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historySpecimen($ihsNumberPatient)
    {
        $url = Url::historySpecimenUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Specimen::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createDiagnosticReportLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null)
    {
        $url = Url::createDiagnosticReportUrl();
        $formData = jsonData\DiagnosticReport::formCreateDataLab($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\DiagnosticReport::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateDiagnosticReportLab($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null)
    {
        $url = Url::updateDiagnosticReportUrl($ihsNumber);
        $formData = jsonData\DiagnosticReport::formUpdateDataLab($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$specimenIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\DiagnosticReport::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function createDiagnosticReportRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null,$imagingStudyIhs = null)
    {
        $url = Url::createDiagnosticReportUrl();
        $formData = jsonData\DiagnosticReport::formCreateDataRadiologi($noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime,$imagingStudyIhs);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\DiagnosticReport::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateDiagnosticReportRadiologi($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime = null,$imagingStudyIhs = null)
    {
        $url = Url::updateDiagnosticReportUrl($ihsNumber);
        $formData = jsonData\DiagnosticReport::formUpdateDataRadiologi($ihsNumber,$noPermintaan,$encounter,$practitioner,$code,$name,$serviceRequestIhs,$observationIhs,$conclusion,$effectiveDateTime,$issuedDateTime,$imagingStudyIhs);
        $http = HttpRequest::put($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\DiagnosticReport::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyDiagnosticReport($ihsNumberPatient)
    {
        $url = Url::historyDiagnosticReportUrl($ihsNumberPatient);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\DiagnosticReport::history($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function searchProductsByCode($code)
    {
        $url = Url::searchProductsByCode($code);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kfa::convertByCode($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function searchProductsByType($type,$start = 1,$limit = 10)
    {
        $url = Url::searchProductsByType($type,$start,$limit);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kfa::convertByType($response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function KycGenerateUrl($nik,$name)
    {
        $url = Url::kycGenerateUrl();
        $keyPair = Security::generateKey();
        $formData = jsonData\Kyc::formDataGenerateUrl($keyPair,$nik,$name);
        $http = HttpRequest::postTextPlain($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kyc::convertGenerateUrl($keyPair,$response);
        }
        return jsonResponse\Error::http($http);
    }

    public static function KycChallengeCode($nik,$name)
    {
        $url = Url::kycChallengeCode();
        $formData = jsonData\Kyc::formDataChallengeCode($nik,$name);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Kyc::convertChallengeCode($response);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Satu-satunya panggilan SSRME resmi (POST /ssrme/v1/hf/shl) per Postman collection
     * "PORTALRME (DES 2025) PROD" - langsung menghasilkan shlinkUrl, tidak ada
     * endpoint/consent step terpisah seperti asumsi awal dari slide presentasi Kemenkes.
     */
    public static function createSsrmeLink($patient,$practitioner,$organization,$encounterId,$emergencyReason = null)
    {
        $url = Url::createSsrmeLinkUrl();
        $formData = $emergencyReason
            ? jsonData\Ssrme::formDataEmergency($patient,$practitioner,$organization,$encounterId,$emergencyReason)
            : jsonData\Ssrme::formData($patient,$practitioner,$organization,$encounterId);
        $http = HttpRequest::post($url,$formData);
        if ($http['status']) {
            $response = $http['response'];
            return jsonResponse\Ssrme::convert($response);
        }
        return jsonResponse\Error::http($http);
    }

    /*
    |--------------------------------------------------------------------------
    | FHIR generik
    |--------------------------------------------------------------------------
    | Semua endpoint di Postman SATUSEHAT PUBLIC ({{base_url}}/{Resource}) bisa
    | dikirim lewat method ini dengan payload array yang sama dengan body Postman.
    */

    public static function createResource($resourceType, array $formData)
    {
        $formData['resourceType'] = $formData['resourceType'] ?? $resourceType;
        $http = HttpRequest::post(Url::fhirUrl($resourceType),$formData);
        if ($http['status']) {
            return jsonResponse\Fhir::convert($http['response'],$resourceType);
        }
        return jsonResponse\Error::http($http);
    }

    public static function updateResource($resourceType, $ihsNumber, array $formData)
    {
        $formData['resourceType'] = $formData['resourceType'] ?? $resourceType;
        $formData['id'] = $ihsNumber;
        $http = HttpRequest::put(Url::fhirUrl($resourceType.'/'.$ihsNumber),$formData);
        if ($http['status']) {
            return jsonResponse\Fhir::convert($http['response'],$resourceType);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * @param array $operations JSON Patch, mis. [['op' => 'add', 'path' => '/problem', 'value' => [...]]]
     */
    public static function patchResource($resourceType, $ihsNumber, array $operations)
    {
        $http = HttpRequest::patch(Url::fhirUrl($resourceType.'/'.$ihsNumber),$operations);
        if ($http['status']) {
            return jsonResponse\Fhir::convert($http['response'],$resourceType);
        }
        return jsonResponse\Error::http($http);
    }

    public static function getResource($resourceType, $ihsNumber)
    {
        $http = HttpRequest::get(Url::fhirUrl($resourceType.'/'.$ihsNumber));
        if ($http['status']) {
            return jsonResponse\Fhir::convert($http['response'],$resourceType);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * @param array $params mis. ['subject' => $ihsPatient, 'encounter' => $ihsEncounter]
     */
    public static function searchResource($resourceType, array $params = [])
    {
        $http = HttpRequest::get(Url::fhirUrl($resourceType,$params));
        if ($http['status']) {
            // tanpa filter tipe: hasil _include (mis. DocumentReference:related) ikut dikembalikan
            return jsonResponse\Fhir::search($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Kirim Bundle transaction (POST {{base_url}}). $entries berisi resource array;
     * fullUrl urn:uuid dibuat otomatis bila resource belum punya 'fullUrl'.
     * Untuk merujuk resource lain dalam bundle pakai Bundle::uuid() lalu "urn:uuid:..." sebagai reference.
     */
    public static function sendBundle(array $entries)
    {
        $formData = jsonData\Bundle::transaction($entries);
        $http = HttpRequest::post(Url::fhirUrl(),$formData);
        if ($http['status']) {
            return jsonResponse\Fhir::bundle($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Resource klinis dengan bagian standar (pasien, encounter, nakes, tanggal) diisi otomatis.
     * $data = field FHIR sesuai body Postman, lihat JsonData\Resource untuk shortcut.
     */
    public static function createClinicalResource($resourceType, $encounter, array $data, $practitioner = null)
    {
        $formData = jsonData\Resource::formData($resourceType,$encounter,$data,$practitioner);
        return self::createResource($resourceType,$formData);
    }

    public static function updateClinicalResource($resourceType, $ihsNumber, $encounter, array $data, $practitioner = null)
    {
        $formData = jsonData\Resource::formData($resourceType,$encounter,$data,$practitioner);
        return self::updateResource($resourceType,$ihsNumber,$formData);
    }

    /**
     * create{Resource}($encounter, array $data, $practitioner = null) dan
     * update{Resource}($ihsNumber, $encounter, array $data, $practitioner = null)
     * untuk resource di JsonData\Resource yang belum punya method khusus,
     * mis. createAllergyIntolerance, createCarePlan, updateGoal, createNutritionOrder.
     */
    public static function __callStatic($method, $args)
    {
        if (preg_match('/^(create|update)([A-Z]\w+)$/', $method, $match) && jsonData\Resource::supports($match[2])) {
            if ($match[1] == 'create') {
                return self::createClinicalResource($match[2], ...$args);
            }
            return self::updateClinicalResource($match[2], ...$args);
        }
        throw new \BadMethodCallException('Method '.static::class.'::'.$method.' tidak ditemukan.');
    }

    /**
     * ImagingStudy hasil DICOM Router dicari berdasarkan Accession Number (ACSN).
     */
    public static function searchImagingStudyByAcsn($acsn)
    {
        $identifier = 'http://sys-ids.kemkes.go.id/acsn/'.Enviroment::organizationId().'|'.$acsn;
        return self::searchResource('ImagingStudy',['identifier' => $identifier]);
    }

    /**
     * Buat pasien baru (by NIK, atau bayi baru lahir dengan identifier nik-ibu).
     * $data = body Postman "Patient - Create", meta profile & active diisi otomatis.
     */
    public static function createPatient(array $data)
    {
        return self::createClinicalResource('Patient',null,$data);
    }

    /**
     * Location / Organization dengan body bebas sesuai Postman (bangsal, ruang, bed,
     * partOf, operationalStatus, extension LocationServiceClass, dst).
     */
    public static function createLocationData(array $data)
    {
        return self::createClinicalResource('Location',null,$data);
    }

    public static function createOrganizationData(array $data)
    {
        return self::createClinicalResource('Organization',null,$data);
    }

    /**
     * Status bed (operationalStatus) via PATCH, sesuai Postman Rawat Inap.
     * $code: O Occupied | U Unoccupied | C Closed | H Housekeeping | I Isolated | K Contaminated
     * $pathExists: false bila Location belum pernah punya operationalStatus (op add), true = op replace.
     */
    public static function updateBedStatus($locationIhs, $code, $pathExists = true)
    {
        $display = [
            'O' => 'Occupied', 'U' => 'Unoccupied', 'C' => 'Closed',
            'H' => 'Housekeeping', 'I' => 'Isolated', 'K' => 'Contaminated'
        ];
        if ($pathExists) {
            $operations = [
                ['op' => 'replace', 'path' => '/operationalStatus/code', 'value' => $code],
                ['op' => 'replace', 'path' => '/operationalStatus/display', 'value' => $display[$code] ?? $code]
            ];
        } else {
            $operations = [
                ['op' => 'add', 'path' => '/operationalStatus/system', 'value' => 'http://terminology.hl7.org/CodeSystem/v2-0116'],
                ['op' => 'add', 'path' => '/operationalStatus/code', 'value' => $code],
                ['op' => 'add', 'path' => '/operationalStatus/display', 'value' => $display[$code] ?? $code]
            ];
        }
        return self::patchResource('Location',$locationIhs,$operations);
    }

    /**
     * e-Resep (Postman "04. Pelayanan - Farmasi"): DocumentReference resep beserta
     * MedicationRequest, Observation & MedicationDispense terkait berdasarkan No. Resep Nasional.
     */
    public static function searchResepNasional($noResepNasional)
    {
        return self::searchResource('DocumentReference',[
            'identifier' => 'http://sys-ids.kemkes.go.id/prescription/national|'.$noResepNasional,
            '_include' => 'DocumentReference:related'
        ]);
    }

    public static function searchMedicationRequestByResepNasional($noResepNasional)
    {
        return self::searchResource('MedicationRequest',[
            'identifier' => 'http://sys-ids.kemkes.go.id/prescription/national|'.$noResepNasional
        ]);
    }

    /**
     * Ganti status EpisodeOfCare (waitlist -> active -> finished, dst) dengan PATCH seperti Postman:
     * replace /status, tutup period statusHistory terakhir, tambah statusHistory baru.
     */
    public static function changeEpisodeOfCareStatus($ihsNumber, $status, $dateTime = null)
    {
        $current = self::getResource('EpisodeOfCare',$ihsNumber);
        if (!$current['status']) {
            return $current;
        }
        $history = $current['data']['resource']['statusHistory'] ?? [];
        $at = Fhir::dateTime($dateTime);
        $closed = in_array($status, ['finished', 'cancelled', 'entered-in-error']);
        $operations = [['op' => 'replace', 'path' => '/status', 'value' => $status]];
        if (count($history) > 0) {
            $operations[] = ['op' => 'add', 'path' => '/statusHistory/'.(count($history) - 1).'/period/end', 'value' => $at];
        }
        $operations[] = ['op' => 'add', 'path' => '/statusHistory/'.count($history), 'value' => [
            'status' => $status,
            'period' => $closed ? ['start' => $at, 'end' => $at] : ['start' => $at]
        ]];
        if ($closed) {
            $operations[] = ['op' => 'add', 'path' => '/period/end', 'value' => $at];
        }
        return self::patchResource('EpisodeOfCare',$ihsNumber,$operations);
    }

    public static function getPatientById($ihsNumber)
    {
        return self::getResource('Patient',$ihsNumber);
    }

    /**
     * Cari pasien tanpa NIK, mis. ['name' => 'patient 8', 'birthdate' => '2015-01-09', 'gender' => 'female'].
     */
    public static function searchPatient(array $params)
    {
        return self::searchResource('Patient',$params);
    }

    public static function getPractitionerById($ihsNumber)
    {
        return self::getResource('Practitioner',$ihsNumber);
    }

    public static function searchPractitioner(array $params)
    {
        return self::searchResource('Practitioner',$params);
    }

    /*
    |--------------------------------------------------------------------------
    | Master Data & KFA (Postman "Master Data API - APIGEE (v2.0)")
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $type provinces | cities | districts | sub-districts
     * @param array $params v1: ['codes' => '11,12'] / ['province_codes' => ...] / ['city_codes' => ...] / ['district_codes' => ...]
     *                      v2: ['current_page' => 1]
     */
    public static function getMasterWilayah($type, array $params = [], $version = 'v1')
    {
        $http = HttpRequest::get(Url::apiUrl('masterdata/'.$version.'/'.$type,$params));
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    public static function getMasterSarana($jenisSarana, $page = 1, $limit = 10)
    {
        $url = Url::apiUrl('masterdata/v1/mastersaranaindex/mastersarana',['limit' => $limit, 'page' => $page, 'jenis_sarana' => $jenisSarana]);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    public static function getKfaPriceJkn($kfaCode, $page = 1, $limit = 10)
    {
        $http = HttpRequest::get(Url::kfaPriceJknUrl($kfaCode,$page,$limit));
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * KFA v3 Alkes: $type 'template' | 'products', $params mis. ['page' => 1, 'size' => 10]
     */
    public static function searchKfaAlkes($type = 'products', array $params = ['page' => 1, 'size' => 10])
    {
        $http = HttpRequest::post(Url::apiUrl('kfa-v3/alkes/'.$type),$params);
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Master Data KPTL (Postman "Master Data API - KPTL"). Set Constant::$kptlUrl terlebih dahulu.
     * $endpoint: code | base_code | base_code_combination | modifier | modifier_value | base_code_by_modifier
     * $body mis. ['method' => 'get_all_code', 'query_string' => '12027', 'offset' => 0, 'limit' => 5]
     */
    public static function searchKptl($endpoint, array $body)
    {
        if (empty(Constant::$kptlUrl)) {
            return ['status' => false, 'message' => 'Constant::$kptlUrl belum diisi (host KPTL tidak tercantum di Postman publik).'];
        }
        $url = rtrim(Constant::$kptlUrl,'/').'/'.$endpoint;
        $http = HttpRequest::postWithHeaders($url,$body,['X-Encryption-Disabled: true']);
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    /**
     * Status pengajuan Data Kelahiran ke Dukcapil (Postman "49. Use Case - Data Kelahiran").
     */
    public static function getStatusDataKelahiran($transactionNumber)
    {
        $url = Url::apiUrl('v1/data-kelahiran-rme/status',[
            'transaction_number' => $transactionNumber,
            'faskes_code' => Enviroment::organizationId()
        ]);
        $http = HttpRequest::get($url);
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    public static function deleteDataKelahiran($transactionNumber)
    {
        $http = HttpRequest::delete(Url::apiUrl('v1/data-kelahiran-rme/delete',['transaction_number' => $transactionNumber]));
        if ($http['status']) {
            return jsonResponse\Fhir::raw($http['response']);
        }
        return jsonResponse\Error::http($http);
    }

    public static function historyPatient($ihsNumber)
    {
        $dataHistory = [];
        $urls['encounter'] = Url::historyEncounterUrl($ihsNumber);
        $urls['condition'] = Url::historyConditionUrl($ihsNumber);
        $urls['observation'] = Url::historyObservationUrl($ihsNumber);
        $urls['composition'] = Url::historyCompositionUrl($ihsNumber);
        $urls['procedure'] = Url::historyProcedureUrl($ihsNumber);
        $urls['medicationRequest'] = Url::historyMedicationRequestUrl($ihsNumber);
        $urls['medicationDispense'] = Url::historyMedicationDispenseUrl($ihsNumber);
        $urls['serviceRequest'] = Url::historyServiceRequestUrl($ihsNumber);
        $urls['specimen'] = Url::historySpecimenUrl($ihsNumber);
        $urls['diagnosticReport'] = Url::historyDiagnosticReportUrl($ihsNumber);
        /////////////////////////////////////
        $gets = HttpRequest::poolGet($urls);
        ///////////////////////////////////
        $getEncounter = $gets['encounter'];
        if ($getEncounter['status']) {
            $dataHistory['encounter'] = jsonResponse\Encounter::history($getEncounter['response']);
        }
        $getCondition = $gets['condition'];
        if ($getCondition['status']) {
            $dataHistory['condition'] = jsonResponse\Condition::history($getCondition['response']);
        }
        $getObservation = $gets['observation'];
        if ($getObservation['status']) {
            $dataHistory['observation'] = jsonResponse\Observation::history($getObservation['response']);
        }
        $getComposition = $gets['composition'];
        if ($getComposition['status']) {
            $dataHistory['composition'] = jsonResponse\Composition::history($getComposition['response']);
        }
        $getProcedure = $gets['procedure'];
        if ($getProcedure['status']) {
            $dataHistory['procedure'] = jsonResponse\Procedure::history($getProcedure['response']);
        }
        $getMedicationRequest = $gets['medicationRequest'];
        if ($getMedicationRequest['status']) {
            $dataHistory['medicationRequest'] = jsonResponse\MedicationRequest::history($getMedicationRequest['response']);
        }
        $getMedicationDispense = $gets['medicationDispense'];
        if ($getMedicationDispense['status']) {
            $dataHistory['medicationDispense'] = jsonResponse\MedicationDispense::history($getMedicationDispense['response']);
        }
        $getServiceRequest = $gets['serviceRequest'];
        if ($getServiceRequest['status']) {
            $dataHistory['serviceRequest'] = jsonResponse\ServiceRequest::history($getServiceRequest['response']);
        }
        $getSpecimen = $gets['specimen'];
        if ($getSpecimen['status']) {
            $dataHistory['specimen'] = jsonResponse\Specimen::history($getSpecimen['response']);
        }
        $getDiagnosticReport = $gets['diagnosticReport'];
        if ($getDiagnosticReport['status']) {
            $dataHistory['diagnosticReport'] = jsonResponse\DiagnosticReport::history($getDiagnosticReport['response']);
        }
        /////////////////////
        return $dataHistory;
    }
}
