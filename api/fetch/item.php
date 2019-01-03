<?php

require_once "../init.php";

$listId = safeGet('listId');
$itemId = safeGet('_id');

$taskitem = safeFind('Taskitem', $itemId);

if ($taskitem->getList()->getId() != $listId) {
    dieWithError("Parent list mismatch");
}

dieOk($taskitem);
