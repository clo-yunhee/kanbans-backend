<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId'];
$listId = $data['listId'];
$itemId = $data['_id'];

if (!isset($itemId)) {
    dieWithError("Item id missing");
}

$taskitem = $entityManager->find('Taskitem', $itemId);

if (!isset($taskitem)) {
    dieWithError("Item not found");
}

if ($taskitem->getList()->getId() != $listId) {
    dieWithError("Item does not belong to this list");
}

if ($taskitem->getList()->getBoard()->getId() != $boardId) {
    dieWithError("Parent list does not belong to this board");
}

$changed = false;

$content = $data['content'];
if (isset($content)) {
    $taskitem->setContent($content);
    $changed = true;
}

$listIndex = $data['listIndex'];
if (isset($listIndex)) {
    if (!is_int($listIndex)) {
        dieWithError("Item list index not an integer");
    }

    $taskitem->setColumnIndex($listIndex);
    $changed = true;
}

if (!$changed) {
    dieWithError("Item not updated");
}

$taskitem->setUpdatedOn();

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);

