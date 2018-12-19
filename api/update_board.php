<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);
$boardId = $data['_id'];

if (!isset($boardId)) {
    dieWithError("Board id missing");
}

$taskboard = $entityManager->find('Taskboard', $boardId);

if (!isset($taskboard)) {
    dieWithError("Board not found");
}

$changed = false;

$boardName = $data['boardName'];
if (isset($boardName)) {
    $taskboard->setBoardName($boardName);
    $changed = true;
}

if (!$changed) {
    dieWithError("Board not updated");
}

$taskboard->setUpdatedOn();

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);

