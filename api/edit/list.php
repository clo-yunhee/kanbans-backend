<?php

require_once "../init.php";

$boardId = safeGet('boardId');
$listId = safeGet('_id');
$listName = safeGet('listName');

$tasklist = safeFind('Tasklist', $listId);

if ($tasklist->getBoard()->getId() != $boardId) {
    dieWithError("Parent board mismatch");
}

$tasklist->setListName($listName);

$entityManager->persist($tasklist);
$entityManager->flush();

dieOk($tasklist);
