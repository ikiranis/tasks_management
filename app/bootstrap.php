<?php

// Start session to use it in the whole app
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
// Get env variable with $_ENV['APP_ENV']
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

