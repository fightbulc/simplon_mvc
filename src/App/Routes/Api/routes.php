<?php

use Simplon\Mvc\App\Routes\Backoffice\RoutePatterns;
use Simplon\Mvc\App\Controllers\Api\SampleRestController;

return [
    [
        'pattern'    => RoutePatterns::HOME,
        'controller' => SampleRestController::class . '::index',
    ],
];
