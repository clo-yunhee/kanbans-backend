<?php

require_once "../../src/bootstrap.php";
require_once "../../src/password.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$username = $data['username']
    ?? dieWithError("Username missing");

$password = $data['password']
    ?? dieWithError("Password missing");

$user = $entityManager->find('User', $username)
    ?? dieWithError("User not found");

$hash = $user->getHash();

if (!verifyPassword($password, $hash)) {
    dieWithError("Wrong password");
}

// todo generate session token
$sessionToken = 'placeholder';

dieOk([
    sessionToken => $sessionToken,
]);


