<?php

require_once "../init.php";

$boardId = safeGet('_id');

$taskboard = $entityManager->find('Taskboard', $boardId);

if (!isset($taskboard)) {
    dieWithError("Board not found");
}

if (array_key_exists('boardName', $data)) {
    $taskboard->setBoardName($data['boardName']);
}

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);

