<?php

require_once "../init.php";

$boardId = safeGet('boardId');
$listId = safeGet('_id');

$tasklist = safeFind('Tasklist', $listId);

if ($tasklist->getBoard()->getId() != $boardId) {
    dieWithError("Parent board mismatch");
}

dieOk($tasklist);
