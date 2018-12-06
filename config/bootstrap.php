<?php

require_once "config/app.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'host' => DB_HOST,
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
