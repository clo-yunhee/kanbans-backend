<?php

require_once "../../src/bootstrap.php";

$boardId = $_GET['board_id'];
$listId = $_GET['list_id'];

if (!isset($listId)) {
    dieWithError("List id missing");
}

$tasklist = $entityManager->find('Tasklist', $listId);

if (!isset($tasklist)) {
    dieWithError("List not found");
}

if ($tasklist->getBoard()->getId() != $boardId) {
    dieWithError("List does not belong to this board");
}

dieOk($tasklist);
