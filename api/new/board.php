<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardName = $data['boardName'];

if (!isset($boardName)) {
    dieWithError("Board name missing");
}

$taskboard = new Taskboard();
$taskboard->setBoardName($boardName);
$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);



