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

$srcList = $taskitem->getList();

if ($srcList->getBoard()->getId() != $boardId) {
    dieWithError("Parent list does not belong to this board");
}

if ($srcList->getId() != $listId) {
    // check if dest list exists
    $destList = $entityManager->find('Tasklist', $listId);

    if (!isset($destList)) {
        dieWithError("New parent list not found");
    }

    if ($destList->getBoard()->getId() != $boardId) {
        dieWithError("New parent list does not belong to this board");
    }

    $taskitem->setList($destList);
}

if (array_key_exists('content', $data)) {
    $taskitem->setContent($data['content']);
}

if (array_key_exists('listIndex', $data)) {
    $listIndex = $data['listIndex'];
    
    if (!is_int($listIndex)) {
        dieWithError("Item list index not an integer");
    }

    $taskitem->setListIndex($listIndex);
}

if (!$taskitem->hasChanged()) {
    dieWithError("Item not updated");
}

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);

