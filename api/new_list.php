<?php

require_once "../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId'];
$name = $data['name'];

if (!isset($boardId)) {
    dieWithError("Parent board identifier missing");
}

$parentBoard = $entityManager->find('Taskboard', $boardId);

if (!isset($parentBoard)) {
    dieWithError("Parent board not found");
}

if (!isset($name)) {
    dieWithError("List name missing");
}

$tasklist = new Tasklist;
$tasklist->setBoard($parentBoard);
$tasklist->setListName($name);

$entityManager->persist($tasklist);
$entityManager->flush();

dieOk($tasklist);



