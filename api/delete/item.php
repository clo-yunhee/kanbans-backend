<?php

require_once "../init.php";

$itemId = safeGet('_id');
$listId = safeGet('listId');

$taskitem = safeFind('Taskitem', $itemId);
$parentList = safeFind('Tasklist', $listId);

if ($taskitem->getList()->getId() !== $parentList->getId()) {
    dieWithError("Parent list mismatch");
}

$entityManager->remove($taskitem);
$entityManager->flush();

dieOk($taskitem->getList()
               ->getItems()
               ->toArray());

