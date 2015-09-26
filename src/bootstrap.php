<?php

use Simplon\Error\ErrorContext;
use Simplon\Mvc\Mvc;

//
// setup session for redis
//

ini_set("session.save_path", 'tcp://' . getenv('REDIS_HOST') . ':' . getenv('REDIS_PORT'));
ini_set("session.save_handler", "redis");

//
// use optimized class map file
//

if (getenv('APP_ENV') !== Mvc::ENV_DEVEL)
{
    $classmap = Mvc::loadFile(__DIR__ . '/../vendor/composer/autoload_classmap.php');
    $autoloadFiles = Mvc::loadFile(__DIR__ . '/../vendor/composer/autoload_files.php');

    if (empty($autoloadFiles) === false)
    {
        foreach ($autoloadFiles as $file)
        {
            Mvc::loadFile($file);
        }
    }

    spl_autoload_register(
        function ($class) use ($classmap)
        {
            Mvc::loadFile($classmap[$class]);
        }
    );
}
else
{
    Mvc::loadFile(__DIR__ . '/../vendor/autoload.php');
}

// ----------------------------------------------

if (getenv('APP_ENV') !== Mvc::ENV_DEVEL)
{
    $errorObserver->addCallback(
        function (ErrorContext $errorContext)
        {
            $message = $errorContext->getData();
            $message['httpCode'] = $errorContext->getHttpCode();

            if (function_exists('newrelic_notice_error'))
            {
                newrelic_notice_error(
                    json_encode($message),
                    $errorContext->getException()
                );
            }
        }
    );
}

// ----------------------------------------------

//
// dispatch MVC
//

echo (new Mvc(getenv('APP_ENV'), $errorObserver))->dispatch();