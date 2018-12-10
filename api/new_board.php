<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$name = $data['name'];

if (!isset($name)) {
    dieWithError("Board name missing");
}

$taskboard = new Taskboard;
$taskboard->setBoardName($name);

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);



