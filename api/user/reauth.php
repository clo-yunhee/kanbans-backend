<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$sessionToken = $data['sessionToken']
    ?? dieWithError("Session token missing");

$tokenRep = $entityManager->getRepository('UserToken');
$token = $tokenRep->findOneBy([ "token" => $sessionToken ]);

$valid = isset($token);

if ($valid) {
    // add other checks, like expiration, etc.

    if (!$valid) {
        $entityManager->remove($token);
        $entityManager->flush();
    }
}

$data = [
    "valid" => $valid
];

if ($valid) {
    $data += [
        "username" => $token->getUser()->getUsername(),
        "sessionToken" => $token->getToken(),
    ]; 
}

dieOk($data);


