<?php

require_once "../init.php";

$headerToken = getToken();
$postToken = safeGet('sessionToken');

if ($headerToken != $postToken) {
    dieWithError("Token mismatch");
}

$token = safeAuth($headerToken);

if ($token == false) {
    dieOk([ "valid" => false ]);
}

dieOk([
    "valid" => true,
    "username" => $token->getUser()->getUsername(),
    "sessionToken" => $token->getToken(),
]);

