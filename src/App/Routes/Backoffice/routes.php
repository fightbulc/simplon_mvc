<?php

use Simplon\Mvc\App\Controllers\Backoffice\DomainController;
use Simplon\Mvc\App\Routes\Backoffice\RouteBuilder;
use Simplon\Mvc\App\Controllers\Backoffice\AuthController;

return [
    [
        'pattern'    => RouteBuilder::PATTERN_HOME,
        'controller' => AuthController::class . '::index',
    ],

    /**
     * catch domain only request. for instance: http://yourdomain.com
     */

    [
        'pattern'    => RouteBuilder::PATTERN_DOMAIN,
        'controller' => DomainController::class . '::index',
    ],
];
