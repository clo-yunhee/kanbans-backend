<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId'];
$listId = $data['_id'];

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

if (array_key_exists('listName', $data)) {
    $tasklist->setListName($data['listName']);
}

if (array_key_exists('columnIndex', $data)) {
    $columnIndex = $data['columnIndex'];

    if (!is_int($columnIndex)) {
        dieWithError("List column index not an integer");
    }

    $tasklist->setColumnIndex($columnIndex);
}

if (!$tasklist->hasChanged()) {
    dieWithError("List not updated");
}

$entityManager->persist($tasklist);
$entityManager->flush();

dieOk($tasklist);
