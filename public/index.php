<?php

use Simplon\Error\ErrorContext;
use Simplon\Mvc\ErrorObserver;
use Simplon\Mvc\Mvc;

//
// error observer
//

$errorObserver = new ErrorObserver(ErrorContext::RESPONSE_TYPE_HTML);

//
// include common bootstap
//

Mvc::loadFile(__DIR__ . '/../src/bootstrap.php');