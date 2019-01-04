<?php

require_once '../init.php';

$token = safeAuth();

$username = safeGet('username');

$user = safeFindOne('User', [ "username" => $username ]);

if ($token == false ||
        $user->getId() != $token->getUser()->getId()) {
    dieWithError("Unauthorized");
}

$shared = safeFindBy('Sharing', [ "user" => $user ]);
$boards = [];

foreach ($shared as $board) {
    $boards[] = [
        "_id" => $board->getId(),
        "username" => $board->getOwner()->getUsername(),
        "boardName" => $board->getBoardName(),
        "createdOn" => $board->getCreatedOn(),
    ];
}

dieOk([ "shared" => $boards ]);
