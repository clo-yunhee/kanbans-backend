<?php

require_once "../../src/bootstrap.php";
require_once "../../src/password.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$sessionToken = $data['sessionToken']
    ?? dieWithError("Session token missing");

$tokenRep = $entityManager->getRepository('UserToken');
$token = $tokenRep->findOneBy([ "token" => $sessionToken ]);

/** /!\ Fail silently if the token doesn't exist. */

if (isset($token)) {
    $entityManager->remove($token);
    $entityManager->flush();
}

dieOk(null);


