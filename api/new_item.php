<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId'];
$listId = $data['listId'];
$content = $data['content'];

if (!isset($boardId)) {
    dieWithError("Parent board identifier missing");
}

$parentBoard = $entityManager->find('Taskboard', $boardId);

if (!isset($parentBoard)) {
    dieWithError("Parent board not found");
}

if (!isset($listId)) {
    dieWithError("Parent list identifier missing");
}

$parentList = $entityManager->find('Tasklist', $listId);

if (!isset($parentList)) {
    dieWithError("Parent list not found");
}

if ($parentList->getBoard()->getId() != $boardId) {
    dieWithError("Parent list does not belong to parent board");
}

if (!isset($content)) {
    dieWithError("Item content missing");
}

$taskitem = new Taskitem;
$taskitem->setList($parentList);
$taskitem->setContent($content);

$entityManager->persist($taskitem);
$entityManager->flush();

dieOk($taskitem);



