<?php

require_once "../init.php";

$listId = safeGet('listId');
$content = safeGet('content');
$listIndex = safeGet('listIndex');

$parentList = safeFind('Tasklist', $listId);

$taskitem = new Taskitem();
$taskitem->setList($parentList);
$taskitem->setContent($content);
$taskitem->setListIndex($listIndex);

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem->getList()
               ->getItems()
               ->toArray());

