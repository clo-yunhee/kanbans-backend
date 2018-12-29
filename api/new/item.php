<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$listId = $data['listId'];
$content = $data['content'];
$listIndex = $data['listIndex'];

if (!isset($listId)) {
    dieWithError("Parent list identifier missing");
}

$parentList = $entityManager->find('Tasklist', $listId);

if (!isset($parentList)) {
    dieWithError("Parent list not found");
}

if (!isset($content)) {
    dieWithError("Item content missing");
}

if (!isset($listIndex)) {
    dieWithError("Item list index missing");
}

$taskitem = new Taskitem($listIndex);
$taskitem->setList($parentList);
$taskitem->setContent($content);
$taskitem->setListIndex($listIndex);

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);

