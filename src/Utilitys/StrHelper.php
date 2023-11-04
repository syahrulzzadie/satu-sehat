<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class StrHelper
{
    public static function getIhsNumber($reference)
    {
        $reference = explode('/',$reference);
        return $reference[1];
    }

    public static function cleanNoRawat($noRawat)
    {
        return str_replace('/','',$noRawat);
    }
}