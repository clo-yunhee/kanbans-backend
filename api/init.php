<?php

require_once "../../src/bootstrap.php";

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
    global $jsonData;

    if (!array_key_exists($key, $jsonData)) {
        dieWithError(ucfirst($key).' missing');
    }
    return $jsonData[$key];
}

// find by id
function safeFind($entityName, $key) {
    global $entityManager;

    $obj = $entityManager->find($entityName, $key);
    if ($obj === null) {
        dieWithError(ucfirst($entityName).' not found');
    }
    return $obj;
}

// find by criteria
function safeFindOne($entityName, $criteria) {
    global $entityManager;

    $rep = $entityManager->getRepository($entityName);
    $obj = $rep->findOneBy($criteria);
    if ($obj === null) {
        dieWithError(ucfirst($entityName).' not found');
    }
    return $obj;
}

function safeFindBy($entityName, $criteria) {
    global $entityManager;

    $rep = $entityManager->getRepository($entityName);
    return $rep->findBy($criteria);
}

// get auth token from request
function getToken() {
    global $authToken;

    if (!isset($authToken)) {
        $matches = [];
        preg_match('/Token (.*)/', $_SERVER['HTTP_AUTHORIZATION'], $matches);
        if (isset($matches[1])) {
            $authToken = $matches[1];
        }
    }

    return $authToken;
}

// get authenticated user
function safeAuth($token = null) {
    global $entityManager;

    $tokenRep = $entityManager->getRepository('UserToken');
    $tokenObj = $tokenRep->findOneBy([ "token" => $token ?? getToken() ]);
    if ($tokenObj === null) {
        return false;
    }

    $valid = true; // add more checks

    if (!$valid) {
        $entityManager->remove($tokenObj);
        $entityManager->flush();
        return false;
    }

    return $tokenObj;
}

header('Content-Type: application/json');

$jsonData = json_decode(file_get_contents('php://input'), true);


