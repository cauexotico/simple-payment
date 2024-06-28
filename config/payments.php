<?php

return [

    /*
    | Supported gateways: "mock01"
    */

    'gateway' => env('PAYMENT_GATEWAY', 'mock01'),

    /*
    | Supported gateways: "mock02"
    */

    'notification' => env('NOTIFICATION_GATEWAY', 'mock02'),
];
