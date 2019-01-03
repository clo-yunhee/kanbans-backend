<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$listId = $data['listId']
    ?? dieWithError("List id missing");

$itemId = $data['_id']
    ?? dieWithError("Item id missing");

$taskitem = $entityManager->find('Taskitem', $itemId)
    ?? dieWithError("Item not found");

if ($taskitem->getList()->getId() != $listId) {
    dieWithError("Item does not belong to this list");
}

dieOk($taskitem);
