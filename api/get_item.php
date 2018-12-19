<?php

require_once "../src/bootstrap.php";

$boardId = $_GET['board_id'];
$listId = $_GET['list_id'];
$itemId = $_GET['item_id'];

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

dieOk($taskitem);
