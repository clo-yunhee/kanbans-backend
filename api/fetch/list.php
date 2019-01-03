<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId']
    ?? dieWithError("Board id missing");

$listId = $data['_id']
    ?? dieWithError("List id missing");

$tasklist = $entityManager->find('Tasklist', $listId)
    ?? dieWithError("List not found");

if ($tasklist->getBoard()->getId() != $boardId) {
    dieWithError("List does not belong to this board");
}

dieOk($tasklist);
