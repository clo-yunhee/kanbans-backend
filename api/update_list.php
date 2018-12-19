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

$changed = false;

$listName = $data['listName'];
if (isset($listName)) {
    $tasklist->setListName($listName);
    $changed = true;
}

$columnIndex = $data['columnIndex'];
if (isset($columnIndex)) {
    if (!is_int($columnIndex)) {
        dieWithError("List column index not an integer");
    }

    $tasklist->setColumnIndex($columnIndex);
    $changed = true;
}

if (!$changed) {
    dieWithError("List not updated");
}

$tasklist->setUpdatedOn();

$entityManager->persist($tasklist);
$entityManager->flush();

dieOk($tasklist);
