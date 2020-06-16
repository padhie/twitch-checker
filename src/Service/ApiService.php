<?php

namespace App\Service;

class ApiService
{
    private const APIKEY = '8woheig63asd';

    public function check(string $givenKey): bool {
        return $givenKey === self::APIKEY;
    }
}