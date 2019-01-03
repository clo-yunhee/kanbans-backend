<?php

require_once "../init.php";

$sessionToken = safeGet('sessionToken');

$tokenRep = $entityManager->getRepository('UserToken');
$token = $tokenRep->findOneBy([ "token" => $sessionToken ]);

$valid = ($token !== null);

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


