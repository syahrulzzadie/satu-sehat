<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

define('_urlHost_','https://api-satusehat-dev.dto.kemkes.go.id');

class Constant
{
    public static $host = _urlHost_;
    public static $authUrl = _urlHost_."/oauth2/v1";
    public static $baseUrl = _urlHost_."/fhir-r4/v1";
    public static $clientId = "GNcAwDI0rtlyAtKT2Jl1NfnJELosLrGAWsSIaaglYttqVT0i";
    public static $clientSecret = "004GXxQtTOQSEAcJe32pBPDnpxOWf4gevgOAIHdCEXOoLpKwZhYeFC4H9UGLBmHe";
    public static $organizationId = "b89d3141-07d2-4c00-8f00-7b0f9965cb02";
}