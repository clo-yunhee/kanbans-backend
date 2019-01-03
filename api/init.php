<?php

require_once "../src/bootstrap.php";

// generate error output
// comment out the msg key in production
function dieWithError($msg) {
    echo json_encode([
        "error" => true,
        "msg" => $msg
    ]);
    die();
}

// generate no error ouput
function dieOk($data) {
    echo json_encode([
        "error" => false,
        "res" => $data
    ]);
    die();
}

// die with msg if unset
function checkExists($var, $msg) {
    if (!isset($var)) {
        dieWithError($msg);
    }
}

// get json key or die if unset
function safeGet($key) {
    if (!array_key_exists($jsonData, $key)) {
        dieWithError(ucfirst($key).' missing');
    }
    return $jsonData[$key];
}

// find by id
function safeFind($entityName, $key) {
    $obj = $entityManager->find($entityManager, $key);
    if ($obj === null) {
        dieWithError(ucfirst($entityName).' not found');
    }
}

// find by criteria
function safeFindOne($entityName, $criteria) {
    $rep = $entityManager->getRepository($entityName);
    $obj = $rep->findOneBy($criteria);
    if ($obj === null) {
        dieWithError(ucfirst($entityName).' not found');
    }
}


header('Content-Type: application/json');

$jsonData = json_decode(file_get_contents('php://input'), true);
