<?php

require_once "../../../src/bootstrap.php";

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

if (array_key_exists('boardName', $data)) {
    $taskboard->setBoardName($data['boardName']);
}

if (!$taskboard->hasChanged()) {
    dieWithError("Board not updated");
}

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);

