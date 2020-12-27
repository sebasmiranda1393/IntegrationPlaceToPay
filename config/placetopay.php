<?php

use Dnetix\Redirection\PlacetoPay;

return [
    'login' => env('PLACE_TO_PAY_LOGIN'),
    'trankey' => env('PLACE_TO_PAY_SECRETKEY'),
    'url' => env('PLACE_TO_PAY_BASE_END_POINT'),
    'type' => env('P2P_TYPE') ?: PlacetoPay::TP_REST,
    'locale' => env('LOCALE'),
    'description' => env('DESCRIPTION'),
];
