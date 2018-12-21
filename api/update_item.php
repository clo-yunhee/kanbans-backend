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

$destList = $taskitem->getList();

if ($destList->getBoard()->getId() != $boardId) {
    dieWithError("Parent list does not belong to this board");
}

$doChangeList = ($destList->getId() != $listId);
if ($doChangeList) {
    // check if dest list exists
    $destList = $entityManager->find('Tasklist', $listId);

    if (!isset($destList)) {
        dieWithError("New parent list not found");
    }

    if ($destList->getBoard()->getId() != $boardId) {
        dieWithError("New parent list does not belong to this board");
    }
}

$changed = true;

if ($doChangeList) {
    $taskitem->setList($destList);
    $changed = true;
}

if (array_key_exists('content', $data)) {
    $taskitem->setContent($data['content']);
    $changed = true;
}

if (array_key_exists('listIndex', $data)) {
    $listIndex = $data['listIndex'];
    
    if (!is_int($listIndex)) {
        dieWithError("Item list index not an integer");
    }

    $taskitem->setListIndex($listIndex);
    $changed = true;
}

if (!$changed) {
    dieWithError("Item not updated");
}

$taskitem->setUpdatedOn();

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);

