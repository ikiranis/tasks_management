<?php

use apps4net\syncDB\services\EnvVariables;

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
// Get env variable with $_ENV['APP_ENV']
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

