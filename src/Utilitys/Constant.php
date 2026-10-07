<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class Constant
{
    public static $authUrl = "https://api-satusehat.kemkes.go.id/oauth2/v1";
    public static $baseUrl = "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
    public static $consentUrl = "https://api-satusehat.kemkes.go.id/consent/v1";
    public static $kfaUrl = "https://api-satusehat.kemkes.go.id/kfa-v2";
    public static $kycUrl = "https://api-satusehat.kemkes.go.id/kyc/v1";
    public static $ssrmeUrl = "https://api-satusehat.kemkes.go.id/ssrme/v1/hf";
    public static $apiUrl = "https://api-satusehat.kemkes.go.id";
    // Host KPTL tidak dicantumkan di Postman publik ({{base_url_kptl}}), isi sesuai info Kemenkes
    public static $kptlUrl = "";
}
