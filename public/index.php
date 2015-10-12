<?php

use Simplon\Error\ErrorContext;
use Simplon\Error\ErrorObserver;
use Simplon\Mvc\Mvc;

//
// use optimized class map file
//

if (getenv('APP_ENV') !== 'dev')
{
    $autoloadFiles = [];
    $pathAutoloadFiles = __DIR__ . '/../vendor/composer/autoload_files.php';

    if (file_exists($pathAutoloadFiles))
    {
        /** @noinspection PhpIncludeInspection */
        $autoloadFiles = require $pathAutoloadFiles;

        if (empty($autoloadFiles) === false)
        {
            foreach ($autoloadFiles as $file)
            {
                /** @noinspection PhpIncludeInspection */
                require $file;
            }
        }
    }

    $classmap = require __DIR__ . '/../vendor/composer/autoload_classmap.php';

    spl_autoload_register(
        function ($class) use ($classmap)
        {
            /** @noinspection PhpIncludeInspection */
            require $classmap[$class];
        }
    );
}
else
{
    require __DIR__ . '/../vendor/autoload.php';
}

// ----------------------------------------------

//
// setup session for redis
//

if (getenv('REDIS_HOST'))
{
    ini_set("session.save_path", 'tcp://' . getenv('REDIS_HOST') . ':' . getenv('REDIS_PORT'));
    ini_set("session.save_handler", "redis");
}

// ----------------------------------------------

//
// error observer
//

$errorObserver = new ErrorObserver(
    getenv('APP_MODULE') === 'api' ? ErrorObserver::RESPONSE_JSON : ErrorObserver::RESPONSE_HTML
);

if (getenv('APP_ENV') === 'production')
{
    $errorObserver->setPathErrorTemplate(__DIR__ . '/../src/Core/Views/Templates/error-production.phtml');
}

$errorObserver->addCallback(
    function (ErrorContext $context)
    {
        $message = $context->getData();
        $message['httpStatusCode'] = $context->getHttpStatusCode();

        if (function_exists('newrelic_notice_error'))
        {
            newrelic_notice_error(
                json_encode($message)
            );
        }
    }
);

// ----------------------------------------------

//
// dispatch MVC
//

echo (new Mvc($errorObserver, getenv('APP_ENV'), getenv('APP_MODULE')))->dispatch();