<?php

if (getenv('APP_ENV') !== 'dev')
{
    $autoloadFiles = [];
    $pathAutoloadFiles = __DIR__ . '/../../../composer/autoload_files.php';

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

    $classmap = require __DIR__ . '/../../..//composer/autoload_classmap.php';

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
    require __DIR__ . '/../../../autoload.php';
}
