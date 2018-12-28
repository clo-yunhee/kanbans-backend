<?php

require_once "../../src/bootstrap.php";
require_once "../../src/password.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$username = $data['username']
    ?? dieWithError("Username missing");

$password = $data['password']
    ?? dieWithError("Password missing");

$oldUser = $entityManager->find('User', $username);
if (isset($oldUser)) {
    dieWithError("User already exists");
}

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


