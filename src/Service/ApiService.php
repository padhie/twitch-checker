<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ApiService
{
    private const REQUEST_KEY = 'apiKey';
    private const APIKEY = '8woheig63asd';

    public function checkByRequest(Request $request): bool {
        return $request->get(self::REQUEST_KEY) === self::APIKEY;
    }
}