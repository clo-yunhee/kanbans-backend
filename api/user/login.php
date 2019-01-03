<?php

require_once "../init.php";
require_once "../../src/password.php";

$username = safeGet('username');
$password = safeGet('password');

$user = safeFindOne('User', [ "username" => $username ]);

$hash = $user->getHash();

if (!verifyPassword($password, $hash)) {
    dieWithError("Wrong password");
}

$ut = UserToken::generate($user);

$entityManager->persist($ut);
$entityManager->flush();

dieOk([
    "username" => $user->getUsername(),
    "sessionToken" => $ut->getToken(),
]);


