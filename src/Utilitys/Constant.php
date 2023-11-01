<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

define('_urlHost_','https://api-satusehat.dto.kemkes.go.id');

class Constant
{
    public static $host = _urlHost_;
    public static $authUrl = _urlHost_."/oauth2/v1";
    public static $baseUrl = _urlHost_."/fhir-r4/v1";
    public static $clientId = "PG6mOnWoj8kexgZEuEw6DfROIjEfcEpIKxdpZwle5KnQzt2i";
    public static $clientSecret = "czAwICyCPcGvEPMtdK5ih0K4LCYT2pPY7H1TW7iuB9yWzGI2qyR3de5ORAPVgDRz";
    public static $organizationId = "100028165";
}