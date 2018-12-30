<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$itemId = $data['_id'];
$listId = $data['listId'];

if (!isset($itemId)) {
    dieWithError("Item id missing");
}

$taskitem = $entityManager->find('Taskitem', $itemId);

if (!isset($taskitem)) {
    dieWithError("Item not found");
}

if (!isset($listId)) {
    dieWithError("Parent list identifier missing");
}

$parentList = $entityManager->find('Tasklist', $listId);

if (!isset($parentList)) {
    dieWithError("Parent list not found");
}

$entityManager->remove($taskitem);
$entityManager->flush();

dieOk($taskitem->getList()
               ->getItems()
               ->toArray());

