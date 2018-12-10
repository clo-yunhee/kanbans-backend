<?php

require_once "../src/bootstrap.php";

$boardId = $_GET['board_id'];

$taskboard = $entityManager->find('Taskboard', $boardId);

if (!isset($taskboard)) {
    dieWithError("Board not found");
}

dieOk($taskboard);
