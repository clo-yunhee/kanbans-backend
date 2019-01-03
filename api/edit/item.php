<?php

require_once "../init.php";

$listId = safeGet('listId');
$itemId = safeGet('_id');
$content = safeGet('content');

$taskitem = safeFind('Taskitem', $itemId);
$parentList = safeFind('Tasklist', $listId);

if ($taskitem->getList()->getId() !== $parentList->getId()) {
    dieWithError("Parent list mismatch");
}

$taskitem->setContent($content);

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);
