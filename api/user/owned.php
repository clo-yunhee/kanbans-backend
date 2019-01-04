<?php

require_once '../init.php';

$token = safeAuth();

$username = safeGet('username');

$user = safeFindOne('User', [ "username" => $username ]);

if ($token == false ||
        $user->getId() != $token->getUser()->getId()) {
    dieWithError("Unauthorized");
}

$owned = $user->getOwnedBoards();
$boards = [];

foreach ($owned as $k => $board) {
    $boards[] = [
        "_id" => $board->getId(),
        "boardName" => $board->getBoardName(),
        "createdOn" => $board->getCreatedOn(),
    ];
}

dieOk([ "owned" => $boards ]);
