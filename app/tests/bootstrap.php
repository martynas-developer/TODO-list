<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// reset DB for tests
if (isset($_ENV['BOOTSTRAP_RESET_DATABASE']) && $_ENV['BOOTSTRAP_RESET_DATABASE'] == true) {
    echo "Resetting test database...";
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:schema:drop --env=test --force --no-interaction',
        __DIR__
    ));
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:schema:update --env=test --force --no-interaction',
        __DIR__
    ));
    echo " Done" . PHP_EOL . PHP_EOL;
}

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}