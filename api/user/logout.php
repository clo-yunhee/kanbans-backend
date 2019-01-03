<?php

require_once "../init.php";

$sessionToken = safeGet('sessionToken');

$token = safeFindOne('UserToken', [ "token" => $sessionToken ]);

$entityManager->remove($token);
$entityManager->flush();

dieOk([ "loggedOut" => true ]);


