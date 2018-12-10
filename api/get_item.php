<?php

require_once "../src/bootstrap.php";

$boardId = $_GET['board_id'];
$listId = $_GET['list_id'];
$itemId = $_GET['item_id'];

$taskitem = $entityManager->find('Taskitem', [
    "boardId" => $boardId,
    "listId" => $listId,
    "id" => $itemId,
]);

if (!isset($taskitem)) {
    dieWithError("Item not found");
}

dieOk($taskitem);
