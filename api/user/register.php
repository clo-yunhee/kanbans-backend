<?php

require_once "../init.php";
require_once "../../src/password.php";

$username = safeGet('username');
$password = safeGet('password');

$oldUser = safeFind('User', $username);

$user = new User($username);

$hash = hashPassword($password);
$user->setHash($hash);

$entityManager->persist($user);
$entityManager->flush();

$ut = UserToken::generate($user);

$entityManager->persist($ut);
$entityManager->flush();

dieOk([
    "username" => $user->getUsername(),
    "sessionToken" => $ut->getToken(),
]);


