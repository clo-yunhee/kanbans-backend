<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['_id']
    ?? dieWithError("Board id missing");

$taskboard = $entityManager->find('Taskboard', $boardId)
    ?? dieWithError("Board not found");

dieOk($taskboard);
