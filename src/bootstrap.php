<?php

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);

header('Content-Type: application/json');

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "config/app.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__), $isDevMode);

// obtaining the entity manager
$entityManager = EntityManager::create([
    'driver' => 'pdo_mysql',
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'host' => DB_HOST
], $config);

// generate error output
function dieWithError($msg) {
    die (json_encode([
        "error" => true,
        "msg" => $msg
    ]));
}

// generate no error ouput
function dieOk($data) {
    die (json_encode([
        "error" => false,
        "res" => $data
    ]));
}
