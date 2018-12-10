<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['name'])) {
    dieWithError("Board name missing");
}

$taskboard = new Taskboard;
$taskboard->setBoardName($data['name']);

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk();



